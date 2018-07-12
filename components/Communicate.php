<?php namespace HolgerBaumann\Communicate\Components;

use Backend\Facades\Backend;
use Cms\Classes\ComponentBase;
use Exception;
use HolgerBaumann\Communicate\Models\Settings;
use HolgerBaumann\Communicate\Models\Communicate as communicateModel;
use HolgerBaumann\Communicate\Models\Communicateblock as Blocks;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\SystemException;
use October\Rain\Support\Facades\Flash;
use Validator;
use ValidationException;
use AjaxException;
use Mail;
use Redirect;

class Communicate extends ComponentBase {

	public $lang;
	public $result;
	public $partsProperties;
	public $languageProperties;
	public $componentProperties;

	public function componentDetails() {
		return [
			'name'        => 'holgerbaumann.communicate::lang.plugin.name',
			'description' => 'holgerbaumann.communicate::lang.component.description',

		];
	}

	public function defineProperties() {
		return [

			'id' => [
				'title'             => 'ID/Titel',
				'description'       => 'The ID and title of the Contact Block to display.',
				'type'              => 'dropdown',
				'options'           => $this->contentBlocks(),
				'required'          => true,
				'validationMessage' => 'Please select a contact block'
			],

			'uniqueCacheIdentifier' => [
				'title'             => 'Unique Cache Identifier',
				'description'       => 'An unique cache identifier (Letters and/or numbers). If a component is used on several pages of the CMS, try to use a different identifier on each usage.',
				'default'           => '',
				'type'              => 'string',
				'placeholder'       => 'Unique Cache Identifier',
				'required'          => true,
				'validationMessage' => 'Please choose an unique cache identifier'
			],

			'referenceID' => [
				'title'             => 'Reference ID',
				'description'       => 'A Reference ID, used to differentiate multiple usages off the contact form on the site.',
				'default'           => 'contactform',
				'type'              => 'string',
				'placeholder'       => 'Reference ID',
				'required'          => true,
				'validationMessage' => 'Please choose a Reference ID'
			],

			'expansion' => [
				'title'       => 'Width of the container.',
				'description' => 'How wide the container of this block should be?',
				'default'     => 'blocked',
				'type'        => 'dropdown',
				'placeholder' => 'Select Expansion',
				'options'     => [
					'container'       => 'blocked',
					'container-fluid' => 'fluid'
				]
			],

			'block-style' => [
				'title'       => 'Style of contact block.',
				'description' => 'What style of contact block',
				'default'     => 'blocked',
				'type'        => 'dropdown',
				'placeholder' => 'Select Expansion',
				'required'    => true,
				'options'     => [
					'generic' => 'generic',
					'clr' => 'card left right (clr)',
					'flr' => 'flat left right (flr)',
					'mlr' => 'card map left right (mlr)'
				]
			],

			'block-style-orientation' => [
				'title'       => 'Orientation of given contact block.',
				'description' => 'What orientation in given contact block',
				'default'     => 'blocked',
				'type'        => 'dropdown',
				'required'    => true,
				'placeholder' => 'Select Expansion',
				'options'     => [
					'left'  => 'left',
					'right' => 'right'
				]
			],

			'displayPhone' => [
				'title'       => 'holgerbaumann.communicate::lang.component.display_phone_field',
				'description' => 'holgerbaumann.communicate::lang.component.display_phone_field_description',
				'default'     => true,
				'type'        => 'checkbox',
			],

		];
	}

	public function properties() {
		return [
			'namePlaceholder'    => Lang::get( 'holgerbaumann.communicate::lang.frontend.name_placeholder' ),
			'emailPlaceholder'   => Lang::get( 'holgerbaumann.communicate::lang.frontend.email_placeholder' ),
			'phonePlaceholder'   => Lang::get( 'holgerbaumann.communicate::lang.frontend.phone_placeholder' ),
			'subjectPlaceholder' => Lang::get( 'holgerbaumann.communicate::lang.frontend.subject_placeholder' ),
			'messagePlaceholder' => Lang::get( 'holgerbaumann.communicate::lang.frontend.message_placeholder' ),

			'success_message' => Lang::get( 'holgerbaumann.communicate::lang.frontend.success_message' ),

			'nameError'           => Lang::get( 'holgerbaumann.communicate::validation.custom.name.required' ),
			'emailError_email'    => Lang::get( 'holgerbaumann.communicate::validation.custom.email.email' ),
			'emailError_required' => Lang::get( 'holgerbaumann.communicate::validation.custom.email.required' ),
			'subjectError'        => Lang::get( 'holgerbaumann.communicate::validation.custom.subject.required' ),
			'messageError'        => Lang::get( 'holgerbaumann.communicate::validation.custom.message.required' ),

			'recaptcha' => Lang::get( 'holgerbaumann.communicate::validation.custom.reCAPTCHA.required' ),

			'phoneEnabled'   => $this->property( 'displayPhone', false ),
			'buttonText'     => Lang::get( 'holgerbaumann.communicate::lang.frontend.buttonText' ),
			'detailedErrors' => $this->property( 'detailedErrors', false ),

			'referenceID' => $this->property( 'referenceID' ),
		];
	}

	public function settings() {
		return [
			'recaptcha_enabled'  => Settings::get( 'recaptcha_enabled', false ),
			'recaptcha_site_key' => Settings::get( 'site_key', '' ),
			'text_top_form'      => Settings::get( 'text_top_form', '' ),
		];

	}

	public function contentBlocks() {

		$a = Cache::remember( 'communicateblocks' . '_' . $this->property( 'uniqueCacheIdentifier' ) . $this->property( 'id' ), env( 'CACHE_PERIOD', 0 ), function () {

			return Blocks::get()->toArray();

		} );

		$cleanedArray = [];

		foreach ( $a as $key => $value ) {
			$identifier = '';

			if ( ! empty( $value['title'] ) ) {
				$identifier = ' / ' . 'Title: ' . $value['title'];
			}

			if ( empty( $value['title'] ) ) {
				$identifier = ' / ' . 'Block-ID: ' . $value['block_id'];
			}

			$cleanedArray[ $value['id'] ] = 'ID: ' . $value['id'] . $identifier;
		}

		return $cleanedArray;
	}


	/**
	 * Injecting Assets
	 */
	public function onRun() {

		$this->lang = \Session::get( 'rainlab.translate.locale' );

		try {
			if ( $this->property( 'id' ) == null ) {
				throw new ApplicationException( 'empty result' );
			}
		} catch ( ApplicationException $ex ) {
			return \Redirect::to( 'error' );
		}

		$property_id = $this->property( 'id' );

		//dd($property_id);

		//dd($this->lang);

		$block = Cache::remember( 'communicateblock' . '_' . $this->lang . '_' . $this->property( 'uniqueCacheIdentifier' ) . $property_id,
			env( 'CACHE_PERIOD', 0 ),
			function () use ( $property_id ) {
				$blocks = $this->getBlock($property_id);
				try {
					if ( $blocks == null ) {
						throw new ApplicationException( 'empty result' );
					}
				}
				catch (ApplicationException $ex) {
					trace_log($ex);
					//die('simpleContact 404');
					return \Response::make($this->controller->run('404'), 404);
				}
				return $blocks->toArray();
			} );

		$this->result = $block;

		$this->componentProperties = $this->getProperties();

		$this->languageProperties = $this->properties();

		$this->addJs( '/plugins/holgerbaumann/communicate/assets/js/simpleContact-frontend.js' );
		if ( Settings::get( 'recaptcha_enabled', false ) ) {
			$this->addJs( 'https://www.google.com/recaptcha/api.js' );
		}
	}

	public function getBlock($id)
	{
		$blocks =  Blocks::find( $id );

		return $blocks;
	}

	/**
	 * AJAX form submit handler
	 */
	public function onFormSubmit() {


		/**
		 * Form validation
		 */
		$customValidationMessages = [
			'name.required'    => trans( 'holgerbaumann.communicate::validation.custom.name.required' ),
			'email.required'   => trans( 'holgerbaumann.communicate::validation.custom.email.required' ),
			'email.email'      => trans( 'holgerbaumann.communicate::validation.custom.email.email' ),
			'subject.required' => trans( 'holgerbaumann.communicate::validation.custom.subject.required' ),
			'message.required' => trans( 'holgerbaumann.communicate::validation.custom.message.required' ),
		];
		$formValidationRules      = [
			'name'    => 'required',
			'email'   => 'required|email',
			'subject' => 'required',
			'message' => 'required',
		];

		$validator = Validator::make( post(), $formValidationRules, $customValidationMessages );

		if ($validator->fails()) {

			$messages = $validator->messages();
			Flash::error($messages->first());

			throw new AjaxException(['#simple_contact_flash_message' => $this->renderPartial('@flashMessage.htm',[
				'errors' => $messages->all()
			])]);
		}

		/*if ( $validator->fails() ) {
			throw new ValidationException( $validator );
		}*/

		/**
		 * Validating reCaptcha
		 */
		if ( Settings::get( 'recaptcha_enabled', false ) ) {

			$response = json_decode( file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=" . Settings::get( 'secret_key' ) . "&response=" . post( 'g-recaptcha-response' ) . "&remoteip=" . $_SERVER['REMOTE_ADDR'] ), true );
			if ( $response['success'] == false ) {
				Flash::error( e( trans( 'holgerbaumann.communicate::validation.custom.reCAPTCHA.required' ) ) );

				throw new AjaxException( [ '#simple_contact_flash_message' => $this->renderPartial( '@flashMessage.htm' ) ] );
			}

		}


		/**
		 * At this point all validations succeded
		 * further processing form
		 */

		$this->submitForm();


		if ( Settings::get( 'redirect_to_page', false ) && ! empty( Settings::get( 'redirect_to_url', '' ) ) ) {
			return Redirect::to( Settings::get( 'redirect_to_url' ) );
		} else {
			Flash::success( Settings::get( 'success_message', 'Thankyou for contacting us' ) );

			return [
				'#simple_contact_flash_message' => $this->renderPartial( '@flashMessage.htm', [
					'message' => 'thx!!!!'
				] )
			];
		}


	}

	protected function submitForm() {

		$model = new communicateModel;

		$model->name    = post( 'name' );
		$model->email   = post( 'email' );
		$model->phone   = post( 'phone' );
		$model->subject = post( 'subject' );
		$model->message = post( 'message' );

		$model->save();

		if ( Settings::get( 'recieve_notification', false ) && ! empty( Settings::get( 'notification_email_address', '' ) ) ) {
			$this->sendNotificationMail( $model->id );
		}

		if ( Settings::get( 'auto_reply', false ) ) {
			$this->sendAutoReply();
		}
	}


	/**
	 * Send notification email
	 */
	protected function sendNotificationMail( $message_id ) {
		$url_message = Backend::url( 'holgerbaumann/communicate/communicate/view/' . $message_id );
		$vars        = [
			'url_message'  => $url_message,
			'name'         => post( 'name' ),
			'email'        => post( 'email' ),
			'phone'        => post( 'phone' ),
			'subject'      => post( 'subject' ),
			'referenceID'  => post( 'referenceID' ),
			'message_body' => post( 'message' )
		];

		Mail::send( 'holgerbaumann.communicate::mail.notification', $vars, function ( $message ) use ( $vars ) {
			$message->to( Settings::get( 'notification_email_address' ) );
			$message->replyTo( $vars['email'], $vars['name'] );
		} );
	}

	/**
	 * send auto reply
	 */
	protected function sendAutoReply() {

		$vars = [
			'name'         => post( 'name' ),
			'email'        => post( 'email' ),
			'phone'        => post( 'phone' ),
			'subject'      => post( 'subject' ),
			'message_body' => post( 'message' )
		];

		Mail::send( 'holgerbaumann.communicate::mail.auto-response', $vars, function ( $message ) {

			$message->to( post( 'email' ), post( 'name' ) );

		} );

	}
}
