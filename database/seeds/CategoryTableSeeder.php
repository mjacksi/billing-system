<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        sections
        \App\Models\Category::create([
            'id' => \App\Models\Posts::POLITICAL_PAPERS,
            'title' => 'أوراق سياسية',
        ]);

        \App\Models\Category::create([
            'id' => \App\Models\Posts::POSITION_ESTIMATION,
            'title' => 'تقدير موقف',
        ]);
        \App\Models\Category::create([
            'id' => \App\Models\Posts::INSTITUTE_STUDIES,
            'title' => 'دراسات المعهد',
        ]);


        \App\Models\Category::create([
            'id' => \App\Models\Posts::REVIEWS_AND_ARTICLES,
            'title' => 'أقلام واراء',
        ]);

        \App\Models\Category::create([
            'id' => \App\Models\Posts::ANALYSIS_AND_DIMENSIONS,
            'title' => 'قضايا ساخنة',
        ]);

        \App\Models\Category::create([
            'id' => \App\Models\Posts::FOREIGN_ANTHOLOGY,
            'title' => 'مختارات أجنبية',
        ]);


//        Activities and events

        \App\Models\Category::create([
            'id' => \App\Models\Posts::NEWS,
            'title' => 'الأخبار',
        ]);

        \App\Models\Category::create([
            'id' => \App\Models\Posts::PANEL_DISCUSSIONS,
            'title' => 'حلقات نقاشية',
        ]);

        \App\Models\Category::create([
            'id' => \App\Models\Posts::WORKSHOPS,
            'title' => 'ورشات عمل',
        ]);


        \App\Models\Category::create([
            'id' => \App\Models\Posts::CONFERENCES,
            'title' => 'مؤتمرات',
        ]);



        /*****/

        \App\Models\Category::create([
            'id' => \App\Models\Posts::INSTITUTE_PUBLICATIONS,
            'title' => 'اصدارات المعهد',
        ]);
        /*****/




        \App\Models\Category::create([
            'id' => \App\Models\Posts::SLIDER,
            'title' => 'سلايدر',
        ]);


        \App\Models\Category::create([
            'id' => \App\Models\Posts::MONTHLY_BULLETIN,
            'title' => 'الراصد البحثي',
        ]);


        \App\Models\Category::create([
            'id' => \App\Models\Posts::ACTIVITIES_AND_EVENTS,
            'title' => 'أنشطة وفعاليات',
        ]);


    }

}
