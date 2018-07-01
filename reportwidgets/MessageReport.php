<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 6/11/2016
 * Time: 1:15 PM
 */

namespace HolgerBaumann\Communicate\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use HolgerBaumann\Communicate\Models\Communicate as CommunicateModel;
class MessageReport extends ReportWidgetBase
{

    public function defineProperties()
    {
        return [
            'title' => [
                'title'             => 'holgerbaumann.communicate::lang.widget.properties_title',
                'default'           => 'Communicate Us Messages',
                'type'              => 'string',
            ],
            'chart' => [
                'title' => 'holgerbaumann.communicate::lang.widget.properties_chart',
                'type'        => 'dropdown',
                'default'     => 'chart-bar',
                'options'     => [
                    'chart-bar'=> e(trans('holgerbaumann.communicate::lang.widget.properties_chart_option_bar')),
                    'chart-pie'=> e(trans('holgerbaumann.communicate::lang.widget.properties_chart_option_pie'))
                ]
            
            ]
        ];
    }
    
    public function render()
    {
        $vars = [
            'title' => $this->property('title','Communicate Us Messages'),
            'chart_type' => $this->property('chart', "chart-bar"),
            'new_messages' => CommunicateModel::where('is_new', true)->count(),
            'replied_messages' => CommunicateModel::where('is_replied', true)->count(),
            'total_messages' => CommunicateModel::count()
        ];
        
        return $this->makePartial('widget',$vars);
    }
}