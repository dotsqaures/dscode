<?php

use Faker\Generator as Faker;

$factory->define(\Modules\AdminUserManager\Entities\AdminRoleAdminUser::class, function (Faker $faker) {
	$type = [1,2];
    $typeIndex = array_rand($type);
    return [
        'admin_role_id' => $type[$typeIndex],
		'admin_user_id' => function () {
		      return factory(\Modules\AdminUserManager\Entities\AdminUser::class)->create()->id;
		    },    
    ];
});
