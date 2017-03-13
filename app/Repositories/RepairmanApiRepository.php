<?php

namespace App\Repositories;

use App\Events\Repairman;
use Illuminate\Database\Eloquent\Model;

class RepairmanApiRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Repairman::class;
    }


    public function getSqlData(){
        $results = app('db')->select(
            "select  id,
            name,
            mobile,
            status,
            address,
            uid,
            geom,
            created_at,
            updated_at,
            ST_AsText(geom),
            ST_DistanceSphere(geom,ST_GeomFromText('point(116.340714 39.992727)',4326)) dist
            from repairmans
            where name is not null
            and  ST_DistanceSphere(geom,ST_GeomFromText('point(116.340714 39.992727)',4326)) < 1000
            order by ST_DistanceSphere(geom,ST_GeomFromText('point(116.340714 39.992727)',4326))
            limit 10"
        );

        return $results;
    }


    public function getResultByWhere($where, $offset = 0, $limit = 10, $devId = '', $userId = 0)
    {

        $repairman = $this->makeModel()->newQuery()->select(
            'id',
            'name',
            'mobile',
            'status',
            'address',
            'uid',
            'geom',
            'created_at',
            'updated_at'
        )
            ->where($where)
            ->limit($limit)
            ->offset($offset)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
//        if($repairman) {
//            foreach($repairman as $key => &$video) {
//                $video['is_favourite'] = $this->checkFavourite($video['id'], $devId, $userId);
//            }
//        }
        return $repairman;
    }

    public function getIndexVideos($where)
    {
        return $this->makeModel()->newQuery()->select('id',
            'name',
            'desc',
            'img_url',
            'video_url',
            'see_num',
            'act_flag as status',
            'created_at',
            'sort_num'
        )
            ->where($where)
            ->orderby('sort_num', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    public function addSeeTimes($videoId)
    {
        $video = $this->makeModel()->newQuery()->select(
            'id',
            'see_num',
            'act_flag as status')
            ->find($videoId);
        if ($video) {
            $video->see_num += 1;
            return $video->save();
        }
        return $video;
    }

    public function getVideoById($videoId, $devId = '', $userId = 0)
    {
        $video = $this->makeModel()->newQuery()->select(
            'id',
            'name',
            'lesson_id',
            'desc',
            'img_url',
            'video_url',
            'see_num',
            'act_flag as status',
            'created_at'
        )
            ->find($videoId);
        if ($video) {
            if ($userId) {
                $video['is_favourite'] = $this->checkFavourite($video->id, $devId, $userId);
            } else {
                $video['is_favourite'] = 0;
            }
        }
        return $video;
    }

    public function checkFavourite($id, $devId = '', $userId = 0)
    {
        if (!$userId) {
            return 0;
        }
        $colWhere = [
            'video_id' => $id,
            'uid' => $userId,
        ];
        return $this->userCollectionApiRepository->getCountByWhere($colWhere);
    }

    public function getVideoInfoById($videoId, $devId = '', $userId = 0)
    {
        $video = $this->makeModel()->newQuery()->select(
            'id',
            'name',
            'lesson_id',
            'desc',
            'img_url',
            'see_num',
            'act_flag as status',
            'created_at'
        )
            ->find($videoId);
        if ($video) {
            if ($userId) {
                $video['is_favourite'] = $this->checkFavourite($video->id, $devId, $userId);
            } else {
                $video['is_favourite'] = 0;
            }
        }
        return $video;
    }

    public function getVideoUrlById($videoId)
    {
        $video = $this->makeModel()->newQuery()->select(
            'id',
            'act_flag as status',
            'created_at'
        )
            ->find($videoId);
        return $video;
    }
}