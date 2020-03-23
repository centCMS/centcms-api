<?php
namespace LightCloud\CentCMS\Api\Plugins;
use Ph\{Security, Config, Response};
use App\Com\Protos\Schemas\Pageable;

class Transform 
{
    public static function cursorToPageable(array $cursor = []) : Pageable
    {
        // $cursor
        // order[0][column]: 0
        // order[0][dir]: asc
        // start: 0
        // length: 10
        $tmp = [];
        $tmp["offset"] = $cursor["start"];
        $tmp["limit"] = $cursor["length"];
        foreach($cursor['order'] as $val) {
            $tmp["orderBys"][] = [
                "direction" => $val["dir"],
                "property"  => $val["column"],
            ];
        }
        return Pageable::fromArray($tmp, true);
    }

    public static function pageToDataTable(array $page, int $draw = 0, array $permissions = [])
    {
        $list = [];
        $list["draw"] = ++$draw;
        $list["recordsTotal"] = $page["totalSize"];
        $list["recordsFiltered"] = $page["totalSize"];
        $list["data"] = $page["data"];
        if(empty($permissions)) {
            $list["operator"] = [
                "view"   => 0,
                "edit"   => 0,
                "delete" => 0,
            ];
        } else {
            $list["operator"] = $permissions;
        }
        Response::setContentType("application/json", "UTF-8");
        Response::setJsonContent($list, \JSON_UNESCAPED_UNICODE);
        return Response::itself();
    }
}