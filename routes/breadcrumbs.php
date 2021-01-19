<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('admin.dashboard'), ['icon' => 'fa fa-dashboard']);
});

// Home > About
Breadcrumbs::for('common', function ($trail, $append) {
    $trail->parent('home');
    if(!empty($append['append'])){
        foreach($append['append'] as $crum){
            $trail->push($crum['label'], isset($crum['route'])? route($crum['route']) : '');
        }
    }

});
