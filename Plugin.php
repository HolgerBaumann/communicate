<?php namespace HolgerBaumann\Communicate;

use Backend;
use System\Classes\PluginBase;
use HolgerBaumann\Communicate\Controllers\Communicate;
/**
 * Communicate Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
	public function pluginDetails()
	{
		return [
			'name'        => 'holgerbaumann.communicate::lang.plugin.name',
			'description' => 'holgerbaumann.communicate::lang.plugin.description',
			'author'      => 'Holger Baumann',
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
			'HolgerBaumann\Communicate\Components\Communicate' => 'Communicate'
		];
	}

	public function registerSettings()
	{
		return [
			'config' => [
				'label'       => 'Communicate',
				'icon'        => 'icon-envelope',
				'description' => 'Manage Settings.',
				'class'       => 'HolgerBaumann\Communicate\Models\Settings',
				'permissions' => ['holgerbaumann.communicate.manage_settings'],
				'order'       => 60
			]
		];
	}

	public function registerNavigation(){
		return [
			'main-menu-item' => [
				'label'       => 'holgerbaumann.communicate::lang.communicate.mainmenu',
				'url'         => Backend::url('holgerbaumann/communicate/communicate'),
				'icon'        => 'icon-envelope',
				'permissions' => ['holgerbaumann.communicate.inbox'],


				'sideMenu' => [
					'side-menu-item' => [
						'label'       => 'holgerbaumann.communicate::lang.communicate.submenu',
						'icon'        => 'icon-inbox',
						'url'         => Backend::url('holgerbaumann/communicate/communicate'),
						'permissions' => ['holgerbaumann.communicate.inbox'],
						'counter'     => Communicate::countUnreadMessages(),
						'counterLabel' => 'Un-Read Messages'
					]

				]

			]
		];
	}

	public function registerMailTemplates()
	{
		return [
			'holgerbaumann.communicate::mail.reply' => 'Communicate -- reply message',
			'holgerbaumann.communicate::mail.auto-response' => 'Communicate -- auto response message',
			'holgerbaumann.communicate::mail.notification' => 'Communicate -- notification mail',
		];
	}

	public function registerReportWidgets()
	{
		return [
			'HolgerBaumann\Communicate\ReportWidgets\MessageReport' => [
				'label'   => 'holgerbaumann.communicate::lang.widget.label',
				'context' => 'dashboard'
			],
		];
	}
}
