<?php namespace HolgerBaumann\SimpleContact\Components;

use Backend\Facades\Backend;
use Cms\Classes\ComponentBase;
use HolgerBaumann\SimpleContact\Models\Settings;
use HolgerBaumann\SimpleContact\Models\Simplecontact as simpleContactModel;
use October\Rain\Support\Facades\Flash;
use Validator;
use AjaxException;
use Mail;
use Redirect;
class Simplecontact extends ComponentBase
{
   
    public function componentDetails()
    {
        return [
            'name'        => 'holgerbaumann.simplecontact::lang.plugin.name',
            'description' => 'holgerbaumann.simplecontact::lang.component.description',

        ];
    }

    public function defineProperties()
    {
        return [
            'nameTitle' => [
                'title' => 'holgerbaumann.simplecontact::lang.component.name_title',
                'description' => 'holgerbaumann.simplecontact::lang.component.name_description',
                'default' => 'Full Name',
                'type' => 'string',
                'required' => true,
                'validationMessage' => 'Title label required'
            ],
            'emailTitle' => [
                'title' => 'holgerbaumann.simplecontact::lang.component.email_title',
                'description' => 'holgerbaumann.simplecontact::lang.component.email_description',
                'default' => 'Email',
                'type' => 'string',
                'required' => true,
                'validationMessage' => 'Email label required'
            ],
            'phoneTitle' => [
                'title' => 'holgerbaumann.simplecontact::lang.component.phone_title',
                'description' => 'holgerbaumann.simplecontact::lang.component.phone_description',
                'default' => 'Phone',
                'type' => 'string'

            ],
            'subjectTitle' => [
                'title' => 'holgerbaumann.simplecontact::lang.component.subject_title',
                'description' => 'holgerbaumann.simplecontact::lang.component.subject_description',
                'default' => 'Subject',
                'type' => 'string',
                'required' => true,
                'validationMessage' => 'Subject label required'

            ],
            'messageTitle' => [
                'title' => 'holgerbaumann.simplecontact::lang.component.message_title',
                'description' => 'holgerbaumann.simplecontact::lang.component.message_description',
                'default' => 'Message',
                'type' => 'string',
                'required' => true,
                'validationMessage' => 'Message label required'

            ],
            'buttonText' => [
                'title' => 'holgerbaumann.simplecontact::lang.component.button_text',
                'description' => 'holgerbaumann.simplecontact::lang.component.button_description',
                'default' => 'Submit',
                'type' => 'string',
                'required' => true,
                'validationMessage' => 'Button text required'

            ],
            'displayPhone' => [
                'title' => 'holgerbaumann.simplecontact::lang.component.display_phone_field',
                'description' => 'holgerbaumann.simplecontact::lang.component.display_phone_field_description',
                'default' => true,
                'type' => 'checkbox',
            ],
            'detailedErrors' => [
                'title'       => 'holgerbaumann.simplecontact::lang.component.detailed_errors_field',
                'description' => 'holgerbaumann.simplecontact::lang.component.detailed_errors_field_description',
                'default'     => false,
                'type'        => 'checkbox',
            ],
        ];
    }

    public function properties(){
        return [
            'nameLabel' => $this->property('nameTitle','Full Name'),
            'emailLabel' => $this->property('emailTitle','Email'),
            'phoneLabel' => $this->property('phoneTitle','Phone No.'),
            'subjectLabel' => $this->property('subjectTitle','Subject'),
            'messageLabel' => $this->property('messageTitle','Message'),
            'phoneEnabled' => $this->property('displayPhone',false),
            'buttonText' => $this->property('buttonText','Submit'),
            'detailedErrors' => $this->property('detailedErrors',false),
        ];
    }

    public function settings(){
        return [
            'recaptcha_enabled' => Settings::get('recaptcha_enabled', false),
            'recaptcha_site_key' => Settings::get('site_key', ''),
            'text_top_form' => Settings::get('text_top_form', ''),

        ];

    }


    /**
     * Injecting Assets
     */
    public function onRun()
    {
        $this->addJs('/plugins/holgerbaumann/simplecontact/assets/js/simpleContact-frontend.js');
        if(Settings::get('recaptcha_enabled', false))
            $this->addJs('https://www.google.com/recaptcha/api.js');
    }

    /**
     * AJAX form fubmit handler
     */
    public function onFormSubmit(){

        /**
         * Form validation
         */
        $customValidationMessages = [
            'name.required' => trans('holgerbaumann.simplecontact::validation.custom.name.required'),
            'email.required' => trans('holgerbaumann.simplecontact::validation.custom.email.required'),
            'email.email' => trans('holgerbaumann.simplecontact::validation.custom.email.email'),
            'subject.required' => trans('holgerbaumann.simplecontact::validation.custom.subject.required'),
            'message.required' => trans('holgerbaumann.simplecontact::validation.custom.message.required'),
        ];
        $formValidationRules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ];

        $validator = Validator::make(post(), $formValidationRules,$customValidationMessages);

        if ($validator->fails()) {

            $messages = $validator->messages();
            Flash::error($messages->first());

            throw new AjaxException(['#simple_contact_flash_message' => $this->renderPartial('@flashMessage.htm',[
                'errors' => $messages->all()
            ])]);
        }

        /**
         * Validating reCaptcha
         */
        if (Settings::get('recaptcha_enabled', false)){

            $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".Settings::get('secret_key')."&response=".post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
            if($response['success'] == false)
            {
                Flash::error(e(trans('holgerbaumann.simplecontact::validation.custom.reCAPTCHA.required')));

                throw new AjaxException(['#simple_contact_flash_message' => $this->renderPartial('@flashMessage.htm')]);
            }

        }


        /**
         * At this point all validations succeded
         * further processing form
         */

         $this->submitForm();



        if(Settings::get('redirect_to_page',false) && !empty(Settings::get('redirect_to_url','')))
            return Redirect::to(Settings::get('redirect_to_url'));
        else{
            Flash::success(Settings::get('success_message','Thankyou for contacting us'));
            return ['#simple_contact_flash_message' => $this->renderPartial('@flashMessage.htm')];
        }


    }

    protected function submitForm(){

        $model = new simpleContactModel;

        $model->name = post('name');
        $model->email = post('email');
        $model->phone = post('phone');
        $model->subject = post('subject');
        $model->message = post('message');

        $model->save();

        if(Settings::get('recieve_notification',false) && !empty(Settings::get('notification_email_address','')))
            $this->sendNotificationMail($model->id);

        if(Settings::get('auto_reply',false))
            $this->sendAutoReply();




    }

    /**
     * Send notification email
     */
    protected function sendNotificationMail($message_id){
        $url_message = Backend::url('holgerbaumann/simplecontact/simplecontact/view/'.$message_id);
        $vars = [
            'url_message' => $url_message,
            'name' => post('name'),
            'email' => post('email'),
            'phone' => post('phone'),
            'subject' => post('subject'),
            'message_body' => post('message')
        ];

        Mail::send('holgerbaumann.simplecontact::mail.notification', $vars, function($message) use ($vars) {
             $message->to(Settings::get('notification_email_address'));
             $message->replyTo($vars['email'], $vars['name']);
        });
    }

    /**
     * send auto reply
     */
    protected function sendAutoReply(){

        $vars = [
            'name' => post('name'),
            'email' => post('email'),
            'phone' => post('phone'),
            'subject' => post('subject'),
            'message_body' => post('message')
        ];

        Mail::send('holgerbaumann.simplecontact::mail.auto-response', $vars, function($message) {

            $message->to(post('email'), post('name'));

        });

    }
}
