<?php namespace HolgerBaumann\Communicate\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Communicateblock extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'holgerbaumann.communicate.manage_settings'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('HolgerBaumann.Communicate', 'main-menu-item');
    }
}