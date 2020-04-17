<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class ApiRoutesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('api_routes')->delete();
        
        \DB::table('api_routes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'path' => '/',
                'name' => 'admin.root',
                'meta' => '{title: APP_NAME + \' | Dashboard\',
iconClass: \'home\',
menuName: \'Dashboard\'}',
                'description' => 'Admin Dashboard',
                'created_at' => '2020-04-17 00:00:00',
                'updated_at' => '2020-04-17 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'path' => '/manage-ui/testimonials',
                'name' => 'admin.ui.testimonials',
                'meta' => '{title: APP_NAME + \' | Manage Testimonials\',
iconClass: \'home\',
menuName: \'Manage Testimonials\'}',
                'description' => 'Manage Testimonials',
                'created_at' => '2020-04-14 00:00:00',
                'updated_at' => '2020-04-16 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'path' => '/manage-ui/faqs',
                'name' => 'admin.ui.faqs',
                'meta' => '{title: APP_NAME + \' | Manage FAQs\',
iconClass: \'home\',
menuName: \'Manage FAQs\'}',
                'description' => 'Manage FAQs',
                'created_at' => '2020-04-12 00:00:00',
                'updated_at' => '2020-04-15 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'path' => '/manage-ui/slides',
                'name' => 'admin.ui.slides',
                'meta' => '{title: APP_NAME + \' | Manage Slideshow\',
iconClass: \'home\',
menuName: \'Manage Slideshow\'
}',
                'description' => 'Manage Slides',
                'created_at' => '2020-04-09 00:00:00',
                'updated_at' => '2020-04-15 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'path' => '/manage-ui/highlights',
                'name' => 'admin.ui.highlights',
                'meta' => '{title: APP_NAME + \' | Manage Highlights\',
iconClass: \'home\',
menuName: \'Manage Highlights\'
}',
                'description' => 'Manage Highlights',
                'created_at' => '2020-04-07 00:00:00',
                'updated_at' => '2020-04-14 00:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'path' => '/manage-media/video',
                'name' => 'admin.media.video',
                'meta' => '{title: APP_NAME + \' | Manage Videos\',
iconClass: \'home\',
menuName: \'Manage Videos\'
}',
                'description' => 'Manage Video',
                'created_at' => '2020-04-05 00:00:00',
                'updated_at' => '2020-04-14 00:00:00',
            ),
            6 => 
            array (
                'id' => 7,
                'path' => '/manage-media/news',
                'name' => 'admin.media.news',
                'meta' => '{title: APP_NAME + \' | Manage News\',
iconClass: \'home\',
menuName: \'Manage News\'
}',
                'description' => 'Manage News',
                'created_at' => '2020-04-02 00:00:00',
                'updated_at' => '2020-04-13 00:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'path' => '/manage-media/gallery',
                'name' => 'admin.media.gallery',
                'meta' => '{title: APP_NAME + \' | Manage Gallery\',
iconClass: \'home\',
menuName: \'Manage Gallery\'
}',
                'description' => 'Manage Gallery',
                'created_at' => '2020-03-31 00:00:00',
                'updated_at' => '2020-04-12 00:00:00',
            ),
            8 => 
            array (
                'id' => 9,
                'path' => '/account/requests',
                'name' => 'admin.account.requests',
                'meta' => '{title: APP_NAME + \' | New Account Requests\',
iconClass: \'home\',
menuName: \'New Account Requests\'
}',
                'description' => 'New Account Requests',
                'created_at' => '2020-03-29 00:00:00',
                'updated_at' => '2020-04-12 00:00:00',
            ),
            9 => 
            array (
                'id' => 10,
                'path' => '/vacancies',
                'name' => 'admin.vacancies',
                'meta' => '{title: APP_NAME + \' | Vacancies\',
iconClass: \'home\',
menuName: \'Vacancies\'
}',
                'description' => 'Manage Vacancies',
                'created_at' => '2020-03-26 00:00:00',
                'updated_at' => '2020-04-11 00:00:00',
            ),
            10 => 
            array (
                'id' => 11,
                'path' => '/logs/auth-attempts',
                'name' => 'admin.logs.auth',
                'meta' => '{title: APP_NAME + \' | Auth Logs\',
iconClass: \'home\',
menuName: \'Auth Logs\'
}',
                'description' => 'View Auth Logs',
                'created_at' => '2020-03-24 00:00:00',
                'updated_at' => '2020-04-11 00:00:00',
            ),
            11 => 
            array (
                'id' => 12,
                'path' => '/admins',
                'name' => 'admin.admins.view',
                'meta' => '{title: APP_NAME + \' | View Admins\',
iconClass: \'home\',
menuName: \'View Admins\'
}',
                'description' => 'View Admins',
                'created_at' => '2020-03-21 00:00:00',
                'updated_at' => '2020-04-10 00:00:00',
            ),
            12 => 
            array (
                'id' => 13,
                'path' => '/messages',
                'name' => 'admin.messages',
                'meta' => '{title: APP_NAME + \' | Messages\',
iconClass: \'home\',
menuName: \'Messages\'
}',
                'description' => 'Messages',
                'created_at' => '2020-03-19 00:00:00',
                'updated_at' => '2020-04-09 00:00:00',
            ),
        ));

        
    }
}