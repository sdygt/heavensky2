<?php

namespace Api\Controller;

use Think\Controller;

class RegionController extends Controller {
    protected $region_model;

    function _initialize()
    {
        $this->region_model = M("region");
    }

    /**
     *获取某一行政区划的子区划
     *
     *输入：GET参数parent_id
     * 缺失时默认返回全国省级行政区划
     * 例如：/heavensky2/index.php?g=api&m=region&a=getChild&parent_id=110100
     * 返回北京市市辖区下属行政区划
     *
     *
     *返回：json对象数组
     * 例如：
     *[{"id":"110101","parent_id":"110100","name":"\u4e1c\u57ce\u533a"},
     * {"id":"110102","parent_id":"110100","name":"\u897f\u57ce\u533a"},
     * ……………………
     * {"id":"110117","parent_id":"110100","name":"\u5e73\u8c37\u533a"}]
     */
    public function getChild()
    {
        $parent_id = intval(I('get.parent_id') ? I('get.parent_id') : 0);
        $result = $this->region_model->where(array( parent_id => $parent_id ))->select();
        $this->ajaxReturn($result);
    }

    /**
     *获取从最高级到某一任一级别指定行政区的路径
     * 输入：GET参数id, 指定地区的编号
     * 返回：json对象数组，从大到小
     */
    public function getPath()
    {
        $id = intval(I('get.id') ? I('get.id') : 0);
        $result = [ ];

        while ($id !== 0) {
            array_unshift($result, $this->region_model->where(array( id => $id ))->find());
            $id = intval($result[0]['parent_id']);
        }
        $this->ajaxReturn($result);
    }

    /**
     *根据地区id获取地区信息
     * 输入：GET参数id，指定地区编号
     * 返回：json对象
     */
    public function getRegionById()
    {
        $id = intval(I('get.id') ? I('get.id') : 0);
        $result = $this->region_model->where(array(id => $id ))->find();
        $this->ajaxReturn($result);
    }


}

