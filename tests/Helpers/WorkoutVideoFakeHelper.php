<?php

namespace Tests\Helpers;

use Illuminate\Support\Facades\Http;

class WorkoutVideoFakeHelper
{
    public static function initServicesFakeData()
    {
        self::kinescopeVideos();

        self::kinescopeVideo();
    }

    public static function kinescopeVideos()
    {
        $data = [
            "meta" => [
                "pagination" => [
                    "page" => 1,
                    "per_page" => 100,
                    "total" => 2
                ],
                "order" => [
                    "title" => "asc"
                ]
            ],
            "data" => [
                [
                    "id" => "404743e1-4ec5-485e-b762-43440a8ab69b",
                    "project_id" => "5c64ee06-3104-4cd4-a364-709d9f291eaf",
                    "folder_id" => null,
                    "player_id" => "aa8fdbd8-f890-4554-bbfd-3325780b3edd",
                    "version" => 1,
                    "title" => "home",
                    "subtitle" => "",
                    "description" => "",
                    "status" => "done",
                    "progress" => 0,
                    "duration" => 57.917,
                    "assets" => [
                        [
                            "id" => "82b31601-8c29-45b2-8f8f-abe1da67b619",
                            "video_id" => "19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7",
                            "original_name" => "original",
                            "file_size" => 40463173,
                            "md5" => "a475adaa656945abbfe50a4e42d22734",
                            "filetype" => "mp4",
                            "quality" => "original",
                            "resolution" => "1280x960",
                            "created_at" => "2022-08-18T02:45:31.303177Z",
                            "url" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/videos/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/assets/82b31601-8c29-45b2-8f8f-abe1da67b619/original.mp4?expires=1665395514&sign=26074b5b06a7a229fefd13ba51dbf6cb",
                            "download_link" => "https://ru-msk-s3.kinescope.io/c3cb5152-9881-4c4f-93d0-3f86791261a9_ec8/videos/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/mp4/original?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=api%2F20221010%2Fus-west-1%2Fs3%2Faws4_request&X-Amz-Date=20221010T092154Z&X-Amz-Expires=3600&X-Amz-SignedHeaders=host&response-content-disposition=attachment&X-Amz-Signature=f647260a48840dd37e4ffc24b3212d52baab59039ab5a4c89f8d69a17e22025d"
                        ],
                        [
                            "id" => "051a97c9-beff-4305-8fdc-c2df395eed90",
                            "video_id" => "00000000-0000-0000-0000-000000000000",
                            "original_name" => "1080p.mp4",
                            "file_size" => 21727831,
                            "filetype" => "mp4",
                            "quality" => "1080p",
                            "resolution" => "1280x960",
                            "created_at" => "2022-08-18T02:50:13.98545Z",
                            "download_link" => ""
                        ],
                        [
                            "id" => "4f4eff02-81aa-4014-bd65-7bc3401c28aa",
                            "video_id" => "00000000-0000-0000-0000-000000000000",
                            "original_name" => "360p.mp4",
                            "file_size" => 4065868,
                            "filetype" => "mp4",
                            "quality" => "360p",
                            "resolution" => "480x360",
                            "created_at" => "2022-08-18T02:50:13.98545Z",
                            "download_link" => ""
                        ],
                        [
                            "id" => "b124218f-fdd1-481f-8a79-3c33c57b02ac",
                            "video_id" => "00000000-0000-0000-0000-000000000000",
                            "original_name" => "480p.mp4",
                            "file_size" => 6714139,
                            "filetype" => "mp4",
                            "quality" => "480p",
                            "resolution" => "640x480",
                            "created_at" => "2022-08-18T02:50:13.98545Z",
                            "download_link" => ""
                        ],
                        [
                            "id" => "98f467dd-d270-4890-abf7-44411eecb307",
                            "video_id" => "00000000-0000-0000-0000-000000000000",
                            "original_name" => "720p.mp4",
                            "file_size" => 13691058,
                            "filetype" => "mp4",
                            "quality" => "720p",
                            "resolution" => "960x720",
                            "created_at" => "2022-08-18T02:50:13.98545Z",
                            "download_link" => ""
                        ]
                    ],
                    "chapters" => [
                        "items" => [
                        ],
                        "enabled" => false
                    ],
                    "privacy_type" => "anywhere",
                    "privacy_domains" => [
                    ],
                    "privacy_share" => [
                        "link_hash" => "rZ3qON",
                        "link" => "https://kinescope.io/201539797/plrZ3qON"
                    ],
                    "tags" => [
                    ],
                    "poster" => [
                        "id" => "7fa8dd55-48b8-4483-9469-2f0944f6c398",
                        "media_id" => "19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7",
                        "status" => "done",
                        "active" => true,
                        "original" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/posters/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/7fa8dd55-48b8-4483-9469-2f0944f6c398.jpg",
                        "md" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/posters/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/md/7fa8dd55-48b8-4483-9469-2f0944f6c398.jpg",
                        "sm" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/posters/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/sm/7fa8dd55-48b8-4483-9469-2f0944f6c398.jpg",
                        "xs" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/posters/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/xs/7fa8dd55-48b8-4483-9469-2f0944f6c398.jpg"
                    ],
                    "additional_materials" => [
                    ],
                    "additional_materials_enabled" => false,
                    "play_link" => "https://kinescope.io/201539797",
                    "embed_link" => "https://kinescope.io/embed/201539797",
                    "created_at" => "2022-08-18T02:45:24.218406Z",
                    "updated_at" => "2022-08-18T03:31:03.564012Z",
                    "subtitles" => [
                    ],
                    "subtitles_enabled" => false,
                    "hls_link" => "https://kinescope.io/201539797/master.m3u8"
                ]
            ]
        ];

        Http::fake([
            config('services.kinescope.url') . '/videos?per_page=100&project_id=5c64ee06-3104-4cd4-a364-709d9f291eaf' => Http::response($data)
        ]);

        return $data;
    }

    public static function kinescopeVideo()
    {
        $data = [
            "data" => [
                "id" => "404743e1-4ec5-485e-b762-43440a8ab69b",
                "project_id" => "5c64ee06-3104-4cd4-a364-709d9f291eaf",
                "folder_id" => null,
                "player_id" => "aa8fdbd8-f890-4554-bbfd-3325780b3edd",
                "version" => 1,
                "title" => "home",
                "subtitle" => "",
                "description" => "",
                "status" => "done",
                "progress" => 0,
                "duration" => 57.917,
                "assets" => [
                    [
                        "id" => "82b31601-8c29-45b2-8f8f-abe1da67b619",
                        "video_id" => "19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7",
                        "original_name" => "original",
                        "file_size" => 40463173,
                        "md5" => "a475adaa656945abbfe50a4e42d22734",
                        "filetype" => "mp4",
                        "quality" => "original",
                        "resolution" => "1280x960",
                        "created_at" => "2022-08-18T02:45:31.303177Z",
                        "url" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/videos/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/assets/82b31601-8c29-45b2-8f8f-abe1da67b619/original.mp4?expires=1665395787&sign=c87ae217cd3aa0816fbd1029b0aa2c8b",
                        "download_link" => "https://ru-msk-s3.kinescope.io/c3cb5152-9881-4c4f-93d0-3f86791261a9_ec8/videos/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/mp4/original?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=api%2F20221010%2Fus-west-1%2Fs3%2Faws4_request&X-Amz-Date=20221010T092627Z&X-Amz-Expires=3600&X-Amz-SignedHeaders=host&response-content-disposition=attachment&X-Amz-Signature=b843b44db4406a611d47728ee65170cc4da4eeade7dc1a6ae9a17d0e66214766"
                    ],
                    [
                        "id" => "051a97c9-beff-4305-8fdc-c2df395eed90",
                        "video_id" => "00000000-0000-0000-0000-000000000000",
                        "original_name" => "1080p.mp4",
                        "file_size" => 21727831,
                        "filetype" => "mp4",
                        "quality" => "1080p",
                        "resolution" => "1280x960",
                        "created_at" => "2022-08-18T02:50:13.98545Z",
                        "download_link" => ""
                    ],
                    [
                        "id" => "98f467dd-d270-4890-abf7-44411eecb307",
                        "video_id" => "00000000-0000-0000-0000-000000000000",
                        "original_name" => "720p.mp4",
                        "file_size" => 13691058,
                        "filetype" => "mp4",
                        "quality" => "720p",
                        "resolution" => "960x720",
                        "created_at" => "2022-08-18T02:50:13.98545Z",
                        "download_link" => ""
                    ],
                    [
                        "id" => "b124218f-fdd1-481f-8a79-3c33c57b02ac",
                        "video_id" => "00000000-0000-0000-0000-000000000000",
                        "original_name" => "480p.mp4",
                        "file_size" => 6714139,
                        "filetype" => "mp4",
                        "quality" => "480p",
                        "resolution" => "640x480",
                        "created_at" => "2022-08-18T02:50:13.98545Z",
                        "download_link" => ""
                    ],
                    [
                        "id" => "4f4eff02-81aa-4014-bd65-7bc3401c28aa",
                        "video_id" => "00000000-0000-0000-0000-000000000000",
                        "original_name" => "360p.mp4",
                        "file_size" => 4065868,
                        "filetype" => "mp4",
                        "quality" => "360p",
                        "resolution" => "480x360",
                        "created_at" => "2022-08-18T02:50:13.98545Z",
                        "download_link" => ""
                    ]
                ],
                "chapters" => [
                    "items" => [
                    ],
                    "enabled" => false
                ],
                "privacy_type" => "anywhere",
                "privacy_domains" => [
                ],
                "privacy_share" => [
                    "link_hash" => "rZ3qON",
                    "link" => "https://kinescope.io/201539797/plrZ3qON"
                ],
                "tags" => [
                ],
                "poster" => [
                    "id" => "7fa8dd55-48b8-4483-9469-2f0944f6c398",
                    "media_id" => "19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7",
                    "status" => "done",
                    "active" => true,
                    "original" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/posters/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/7fa8dd55-48b8-4483-9469-2f0944f6c398.jpg",
                    "md" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/posters/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/md/7fa8dd55-48b8-4483-9469-2f0944f6c398.jpg",
                    "sm" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/posters/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/sm/7fa8dd55-48b8-4483-9469-2f0944f6c398.jpg",
                    "xs" => "https://kinescopecdn.net/c3cb5152-9881-4c4f-93d0-3f86791261a9/posters/19d4d8c9-26f6-4d6d-b7f8-ebd60ced3dd7/xs/7fa8dd55-48b8-4483-9469-2f0944f6c398.jpg"
                ],
                "additional_materials" => [
                ],
                "additional_materials_enabled" => false,
                "play_link" => "https://kinescope.io/201539797",
                "embed_link" => "https://kinescope.io/embed/201539797",
                "created_at" => "2022-08-18T02:45:24.218406Z",
                "updated_at" => "2022-08-18T03:31:03.564012Z",
                "subtitles" => [
                ],
                "subtitles_enabled" => false,
                "hls_link" => "https://kinescope.io/201539797/master.m3u8"
            ]
        ];

        Http::fake([
            config('services.kinescope.url') . '/videos/404743e1-4ec5-485e-b762-43440a8ab69b' => Http::response($data)
        ]);

        return $data;
    }

}
