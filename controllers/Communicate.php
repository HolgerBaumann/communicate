<?php namespace HolgerBaumann\Communicate\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Backend\Facades\Backend;
use HolgerBaumann\Communicate\Classes\ZHelper;
use HolgerBaumann\Communicate\Models\Communicate as CommunicateModel;
use October\Rain\Support\Facades\Flash;
use Illuminate\Support\Facades\Redirect;
use Mail;
use Validator;
use ValidationException;
use System\Classes\SettingsManager;
class Communicate extends Controller
{
    public $requiredPermissions = ['holgerbaumann.communicate.inbox'];
    
    public $implement = ['Backend\Behaviors\ListController'];

    public $listConfig = 'config_list.yaml';

    

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HolgerBaumann.Communicate', 'main-menu-item');

        SettingsManager::setContext('HolgerBaumann.Communicate', 'communicate');
    }


    /**
     * Injecting css class 'new' to list row if its new record
     *
     * @param $record
     * @param null $definition
     * @return string
     */
    public function listInjectRowClass($record, $definition = null)
    {
        if ($record->is_new) {
            return 'new';
        }
    }

    /**
     * count unread messages to show
     * counter on the side menu
     */
    public static function countUnreadMessages()
    {
        $counter = CommunicateModel::where('is_new', true)->count();

        if ($counter > 0)
            return $counter;
        else
            return null;

    }


    /**
     * (AJAX Call)
     * Delete items from the list.
     *
     */
    public function onDelete()
    {
        /** Check if this is even set **/
        

        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            CommunicateModel::whereIn('id',$checkedIds)->delete();

        }

        $counter = CommunicateModel::where('is_new', true)->count();

        return [
            'counter' => $counter,
            'list' => $this->listRefresh()
            ];
    }


    /**
     * (AJAX Call)
     * Delete single message
     *
     * @return mixed
     */
    public function onDeleteSingle(){
        $id = post('id' );
        $record = CommunicateModel::find($id);

        if($record){

            $record->delete();
            Flash::success(e(trans('holgerbaumann.communicate::lang.communicate.message_delete_success')));
        }
        else{
            Flash::error(e(trans('holgerbaumann.communicate::lang.communicate.message_delete_error')));
        }


        return Redirect::to(Backend::url('holgerbaumann/communicate/communicate'));
    }

    /**
     * send message reply
     */
    public function onReplyMessage(){


        $formValidationRules = [
            'subject' => ['required'],
            'message' => ['required']
        ];

        $validator = Validator::make(post(), $formValidationRules);
        // Validate
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $record = CommunicateModel::find(post('id'));

        if($record){

            $vars = [
                'message_body' => nl2br(post('message'))
            ];

            Mail::send('holgerbaumann.communicate::mail.reply', $vars, function($message) {

                $message->to(post('email_to'), post('name_to'));
                $message->subject(post('subject'));

            });

            $record->is_replied = true;
            $record->save();

            Flash::success(e(trans('holgerbaumann.communicate::lang.communicate.message_reply_success')));
        }
        else {
            Flash::error(e(trans('holgerbaumann.communicate::lang.communicate.message_reply_error')));
        }

    }


    /**
     * view single message details
     *
     * @param $id
     */
    public function view($id){
        $message = CommunicateModel::find($id);
        if($message){
            $message->is_new = false;
            $message->save();

            $this->addCss("/plugins/holgerbaumann/communicate/assets/css/backend-custom.css", "1.0.0");
            $this->addCss("/plugins/holgerbaumann/communicate/assets/css/print-message.css", "media=\"print\"");
            $this->addJs("/plugins/holgerbaumann/communicate/assets/js/printThis.js");
            $this->addJs("/plugins/holgerbaumann/communicate/assets/js/Communicate.js");

            $this->pageTitle = "Message";
            $this->vars['message'] = $message;
            $this->vars['avatar'] = ZHelper::get_gravatar($message->email);
        }
        else{
            Flash::error(e(trans('holgerbaumann.communicate::lang.communicate.message_not_found_error')));
            return Redirect::to(Backend::url('holgerbaumann/communicate/communicate'));
        }

    }



}
