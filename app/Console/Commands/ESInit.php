<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class ESInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '这是ES初始化脚本';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //1、创建template
        $client = new Client();
        $url = $url = config('scout.elasticsearch.hosts')[0] . '/_template/tmp';//创建一个叫tmp的模板
        //$client->delete($url);//确保这个模板不存在
        $param_template = [
            'json' => [
                'template' => config('scout.elasticsearch.index'),
                'settings' => [
                    'number_of_shards' => 1
                ],
                'mappings' => [
                    '_default_' => [
                        '_all' => [
                            'enabled' => true
                        ],
                        'dynamic_templates' => [
                            [
                                'strings' => [
                                    'match_mapping_type' => 'string',
                                    'mapping' => [
                                        'type' => 'text',
                                        'analyzer' => 'ik_smart',
                                        'ignore_above' => 256,
                                        'fields' => [
                                            'keyword' => [
                                                'type' => 'keyword'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $client->put($url, $param_template);

        $this->info("========= 创建模板成功 =========");

        //2、创建index
        $url = config('scout.elasticsearch.hosts')[0].'/'.config('scout.elasticsearch.index');
        //$client->delete($url);
        $param_indx = [
            'json' => [
                'settings' => [
                    'refresh_interval' => '5s',
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    '_default_' => [
                        '_all' => [
                            'enabled' => false
                        ]
                    ]
                ]
            ],
        ];
        $client->put($url, $param_indx);

        $this->info("========= 创建索引成功 =========");
    }
}
