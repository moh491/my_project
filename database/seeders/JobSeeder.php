<?php

namespace Database\Seeders;

use App\Models\CompanyJob;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CompanyJob::truncate();

        $jobs = [
            'en' => [
                [
                    'title' => 'Software Engineer',
                    'description' => 'Develop and maintain software applications.',
                    'responsibilities' => [
                        'Write clean and efficient code.',
                        'Collaborate with cross-functional teams.',
                        'Debug and resolve technical issues.'
                    ],
                    'requirements' => [
                        'Bachelor’s degree in Computer Science.',
                        'Experience with software development.',
                        'Proficiency in programming languages.'
                    ]
                ],
                [
                    'title' => 'Data Analyst',
                    'description' => 'Analyze data to provide business insights.',
                    'responsibilities' => [
                        'Collect and interpret data.',
                        'Identify patterns and trends.',
                        'Report findings to stakeholders.'
                    ],
                    'requirements' => [
                        'Degree in Statistics or related field.',
                        'Experience with data analysis tools.',
                        'Strong analytical skills.'
                    ]
                ],
                [
                    'title' => 'Product Manager',
                    'description' => 'Manage product development from start to finish.',
                    'responsibilities' => [
                        'Define product vision and strategy.',
                        'Work with engineering teams.',
                        'Gather and prioritize product requirements.'
                    ],
                    'requirements' => [
                        'Experience as a Product Manager.',
                        'Strong leadership skills.',
                        'Excellent communication skills.'
                    ]
                ],
                [
                    'title' => 'Marketing Specialist',
                    'description' => 'Develop and implement marketing strategies.',
                    'responsibilities' => [
                        'Conduct market research.',
                        'Create marketing campaigns.',
                        'Monitor campaign performance.'
                    ],
                    'requirements' => [
                        'Degree in Marketing or related field.',
                        'Experience in digital marketing.',
                        'Excellent communication skills.'
                    ]
                ],
                [
                    'title' => 'Network Engineer',
                    'description' => 'Design and implement computer networks.',
                    'responsibilities' => [
                        'Install and configure network hardware.',
                        'Troubleshoot network issues.',
                        'Monitor network performance.'
                    ],
                    'requirements' => [
                        'Degree in Computer Networking.',
                        'Experience with network infrastructure.',
                        'Certification in networking (e.g., CCNA).'
                    ]
                ],
                [
                    'title' => 'UX Designer',
                    'description' => 'Design user interfaces for web and mobile applications.',
                    'responsibilities' => [
                        'Create wireframes and prototypes.',
                        'Conduct user research.',
                        'Collaborate with developers.'
                    ],
                    'requirements' => [
                        'Degree in Design or related field.',
                        'Experience in UX design.',
                        'Proficiency in design tools (e.g., Sketch, Figma).'
                    ]
                ],
                [
                    'title' => 'DevOps Engineer',
                    'description' => 'Manage software development and deployment processes.',
                    'responsibilities' => [
                        'Automate deployment pipelines.',
                        'Monitor system performance.',
                        'Collaborate with development teams.'
                    ],
                    'requirements' => [
                        'Degree in Computer Science.',
                        'Experience with CI/CD tools.',
                        'Proficiency in scripting languages.'
                    ]
                ],
                [
                    'title' => 'Cybersecurity Specialist',
                    'description' => 'Protect systems and networks from cyber threats.',
                    'responsibilities' => [
                        'Implement security measures.',
                        'Monitor for security breaches.',
                        'Conduct security assessments.'
                    ],
                    'requirements' => [
                        'Degree in Cybersecurity or related field.',
                        'Experience with security tools.',
                        'Certification in cybersecurity (e.g., CISSP).'
                    ]
                ],
                [
                    'title' => 'Cloud Engineer',
                    'description' => 'Manage cloud infrastructure and services.',
                    'responsibilities' => [
                        'Design cloud architecture.',
                        'Monitor cloud performance.',
                        'Ensure cloud security.'
                    ],
                    'requirements' => [
                        'Degree in Computer Science.',
                        'Experience with cloud platforms (e.g., AWS, Azure).',
                        'Certification in cloud computing.'
                    ]
                ],
                [
                    'title' => 'Machine Learning Engineer',
                    'description' => 'Develop and deploy machine learning models.',
                    'responsibilities' => [
                        'Build and train machine learning models.',
                        'Evaluate model performance.',
                        'Collaborate with data scientists.'
                    ],
                    'requirements' => [
                        'Degree in Computer Science or related field.',
                        'Experience with machine learning frameworks.',
                        'Proficiency in programming languages (e.g., Python, R).'
                    ]
                ]
            ],
            'ar' => [
                [
                    'title' => 'مهندس برمجيات',
                    'description' => 'تطوير وصيانة تطبيقات البرمجيات.',
                    'responsibilities' => [
                        'كتابة كود نظيف وفعال.',
                        'التعاون مع الفرق الوظيفية المختلفة.',
                        'تصحيح وحل المشكلات التقنية.'
                    ],
                    'requirements' => [
                        'درجة البكالوريوس في علوم الكمبيوتر.',
                        'خبرة في تطوير البرمجيات.',
                        'إتقان لغات البرمجة.'
                    ]
                ],
                [
                    'title' => 'محلل بيانات',
                    'description' => 'تحليل البيانات لتقديم رؤى تجارية.',
                    'responsibilities' => [
                        'جمع وتفسير البيانات.',
                        'تحديد الأنماط والاتجاهات.',
                        'تقديم النتائج لأصحاب المصلحة.'
                    ],
                    'requirements' => [
                        'درجة في الإحصاء أو مجال ذي صلة.',
                        'خبرة في أدوات تحليل البيانات.',
                        'مهارات تحليلية قوية.'
                    ]
                ],
                [
                    'title' => 'مدير منتج',
                    'description' => 'إدارة تطوير المنتج من البداية إلى النهاية.',
                    'responsibilities' => [
                        'تحديد رؤية واستراتيجية المنتج.',
                        'العمل مع فرق الهندسة.',
                        'جمع وتحديد أولويات متطلبات المنتج.'
                    ],
                    'requirements' => [
                        'خبرة كمدير منتج.',
                        'مهارات قيادية قوية.',
                        'مهارات اتصال ممتازة.'
                    ]
                ],
                [
                    'title' => 'متخصص تسويق',
                    'description' => 'تطوير وتنفيذ استراتيجيات التسويق.',
                    'responsibilities' => [
                        'إجراء أبحاث السوق.',
                        'إنشاء حملات تسويقية.',
                        'مراقبة أداء الحملة.'
                    ],
                    'requirements' => [
                        'درجة في التسويق أو مجال ذي صلة.',
                        'خبرة في التسويق الرقمي.',
                        'مهارات اتصال ممتازة.'
                    ]
                ],
                [
                    'title' => 'مهندس شبكات',
                    'description' => 'تصميم وتنفيذ الشبكات الحاسوبية.',
                    'responsibilities' => [
                        'تثبيت وتكوين أجهزة الشبكة.',
                        'حل مشكلات الشبكة.',
                        'مراقبة أداء الشبكة.'
                    ],
                    'requirements' => [
                        'درجة في شبكات الحاسوب.',
                        'خبرة في بنية الشبكة.',
                        'شهادة في الشبكات (مثل CCNA).'
                    ]
                ],
                [
                    'title' => 'مصمم تجربة المستخدم',
                    'description' => 'تصميم واجهات المستخدم لتطبيقات الويب والجوال.',
                    'responsibilities' => [
                        'إنشاء الرسومات والنماذج الأولية.',
                        'إجراء أبحاث المستخدمين.',
                        'التعاون مع المطورين.'
                    ],
                    'requirements' => [
                        'درجة في التصميم أو مجال ذي صلة.',
                        'خبرة في تصميم تجربة المستخدم.',
                        'إتقان أدوات التصميم (مثل Sketch، Figma).'
                    ]
                ],
                [
                    'title' => 'مهندس DevOps',
                    'description' => 'إدارة عمليات تطوير البرمجيات والنشر.',
                    'responsibilities' => [
                        'أتمتة خطوط النشر.',
                        'مراقبة أداء النظام.',
                        'التعاون مع فرق التطوير.'
                    ],
                    'requirements' => [
                        'درجة في علوم الكمبيوتر.',
                        'خبرة في أدوات CI/CD.',
                        'إتقان لغات البرمجة النصية.'
                    ]
                ],
                [
                    'title' => 'أخصائي الأمن السيبراني',
                    'description' => 'حماية الأنظمة والشبكات من التهديدات السيبرانية.',
                    'responsibilities' => [
                        'تنفيذ إجراءات الأمان.',
                        'مراقبة الانتهاكات الأمنية.',
                        'إجراء تقييمات الأمان.'
                    ],
                    'requirements' => [
                        'درجة في الأمن السيبراني أو مجال ذي صلة.',
                        'خبرة في أدوات الأمان.',
                        'شهادة في الأمن السيبراني (مثل CISSP).'
                    ]
                ],
                [
                    'title' => 'مهندس سحابة',
                    'description' => 'إدارة البنية التحتية والخدمات السحابية.',
                    'responsibilities' => [
                        'تصميم بنية السحابة.',
                        'مراقبة أداء السحابة.',
                        'ضمان أمان السحابة.'
                    ],
                    'requirements' => [
                        'درجة في علوم الكمبيوتر.',
                        'خبرة في منصات السحابة (مثل AWS، Azure).',
                        'شهادة في الحوسبة السحابية.'
                    ]
                ],
                [
                    'title' => 'مهندس تعلم الآلة',
                    'description' => 'تطوير ونشر نماذج تعلم الآلة.',
                    'responsibilities' => [
                        'بناء وتدريب نماذج تعلم الآلة.',
                        'تقييم أداء النموذج.',
                        'التعاون مع علماء البيانات.'
                    ],
                    'requirements' => [
                        'درجة في علوم الكمبيوتر أو مجال ذي صلة.',
                        'خبرة في أطر تعلم الآلة.',
                        'إتقان لغات البرمجة (مثل Python، R).'
                    ]
                ]
            ]
        ];
        $location_types = ['On-site', 'Hybrid', 'Remote'];
        $employment_types = ['Full_time', 'Part_time', 'Self_employed', 'Freelance','Contract','Internship','Seasonal','Apprenticeship'];
        $levels = ['Junior', 'Mid', 'Senior'];
        $min_salaries = [200, 300, 400, 500, 600, 700];
        $max_salaries = [800, 900, 1000, 1200, 1300,1400];
        $position_ids = range(1, 7);


        $companies = DB::table('companies')->get();
        $companyIndex = 0;

        foreach ($companies as $company) {
            $jobData = ($companyIndex < 10) ? $jobs['en'][$companyIndex % 10] : $jobs['ar'][$companyIndex % 10];
            DB::table('company_jobs')->insert([
                'title' => $jobData['title'],
                'description' => $jobData['description'],
                'location_type' => $location_types[array_rand($location_types)],
                'employment_type' => $employment_types[array_rand($employment_types)],
                'level' => $levels[array_rand($levels)],
                'min_salary' => $min_salaries[array_rand($min_salaries)],
                'max_salary' => $max_salaries[array_rand($max_salaries)],
                'responsibilities' => json_encode($jobData['responsibilities'], JSON_UNESCAPED_UNICODE),
                'requirements' => json_encode($jobData['requirements'], JSON_UNESCAPED_UNICODE),
                'position_id' => $position_ids[array_rand($position_ids)],
                'company_id' => $company->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $companyIndex++;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



//        $array = [
//            "Proven experience as a Front-end Developer or similar role",
//            'Strong proficiency in HTML, CSS, and JavaScript',
//            'Experience with front-end frameworks and libraries (e.g., React, Angular, Vue.js)',
//            'Familiarity with RESTful APIs and asynchronous request handling',
//            'Solid understanding of responsive design principles and mobile-first approach',
//            'Experience with version control systems (e.g., GitExcellent problem-solving skills and attention to data'
//        ];
//        CompanyJob::truncate();
//        CompanyJob::create([
//            'title' => "Backend Developer",
//            'location_type' => 1,
//            'employment_type' => 1,
//            'level' => 1,
//            'description' => 'We are looking for a skilled Front-end Developer to join our creative team As a Front-end Developer you will be responsible for implementing visua interactive elements that users engage with through web browsers You will work closely with designers and back-end developers to deliver high-quality responsive web applications',
//            'min_salary' => '1000',
//            'max_salary' => '3000',
//            'responsibilities' => json_encode($array),
//            'position_id' => 1,
//            'company_id' => 1,
//        ]);
//        CompanyJob::create([
//            'title' => "UI/UX Designer",
//            'location_type' => 2,
//            'employment_type' => 2,
//            'level' => 2,
//            'description' => 'We are seeking a talented Back-end Developer to join our growing team. As a Back-end Developer, you will be responsible for designing, developing, and maintaining server-side logic and databases for our web applications. You will work closely with front-end developers, UI/UX designers, and stakeholders to deliver scalable and efficient solutions',
//            'min_salary' => '1000',
//            'max_salary' => '3000',
//            'responsibilities' => json_encode($array),
//            'position_id' => 2,
//            'company_id' => 1,
//        ]);
//        CompanyJob::create([
//            'title' => "UI/UX Designer",
//            'location_type' => 2,
//            'employment_type' => 2,
//            'level' => 2,
//            'description' => 'We are seeking a versatile Full-stack Developer to join our development team. As a Full-stack Developer, you will be responsible for designing, developing, and maintaining web applications across the entire stack. You will work on both front-end and back-end technologies to deliver scalable and responsive solutions',
//            'min_salary' => '1000',
//            'max_salary' => '3000',
//            'responsibilities' => json_encode($array),
//            'position_id' => 3,
//            'company_id' => 1,
//        ]);
//


    }
}
