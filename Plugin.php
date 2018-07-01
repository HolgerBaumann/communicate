<?php namespace HolgerBaumann\SimpleContact;

use System\Classes\PluginBase;
use Backend;
use HolgerBaumann\SimpleContact\Controllers\Simplecontact;
class Plugin extends PluginBase
{

	public function pluginDetails()
	{
		return [
			'name'        => 'holgerbaumann.simplecontact::lang.plugin.name',
			'description' => 'holgerbaumann.simplecontact::lang.plugin.description',
			'author'      => 'Jawad',
			'icon'        => 'icon-envelope'
		];
	}

	/**
	 * @var array Plugin dependencies
	 */
	public $require = ['RainLab.Translate'];

	public function registerComponents()
	{
		return [
			'HolgerBaumann\SimpleContact\Components\Simplecontact' => 'simpleContact'
		];
	}

	public function registerSettings()
	{
		return [
			'config' => [
				'label'       => 'Simple Contact',
				'icon'        => 'icon-envelope',
				'description' => 'Manage Settings.',
				'class'       => 'HolgerBaumann\SimpleContact\Models\Settings',
				'permissions' => ['holgerbaumann.simplecontact.manage_settings'],
				'order'       => 60
			]
		];
	}

	public function registerNavigation(){
		return [
			'main-menu-item' => [
				'label'       => 'holgerbaumann.simplecontact::lang.simplecontact.mainmenu',
				'url'         => Backend::url('holgerbaumann/simplecontact/simplecontact'),
				'icon'        => 'icon-envelope',
				'permissions' => ['holgerbaumann.simplecontact.inbox'],


				'sideMenu' => [
					'side-menu-item' => [
						'label'       => 'holgerbaumann.simplecontact::lang.simplecontact.submenu',
						'icon'        => 'icon-inbox',
						'url'         => Backend::url('holgerbaumann/simplecontact/simplecontact'),
						'permissions' => ['holgerbaumann.simplecontact.inbox'],
						'counter'     => Simplecontact::countUnreadMessages(),
						'counterLabel' => 'Un-Read Messages'
					]

				]

			]
		];
	}

	public function registerMailTemplates()
	{
		return [
			'holgerbaumann.simplecontact::mail.reply' => 'Simple Contact -- reply message',
			'holgerbaumann.simplecontact::mail.auto-response' => 'Simple Contact -- auto response message',
			'holgerbaumann.simplecontact::mail.notification' => 'Simple Contact -- notification mail',
		];
	}

	public function registerReportWidgets()
	{
		return [
			'HolgerBaumann\SimpleContact\ReportWidgets\MessageReport' => [
				'label'   => 'holgerbaumann.simplecontact::lang.widget.label',
				'context' => 'dashboard'
			],
		];
	}
}
