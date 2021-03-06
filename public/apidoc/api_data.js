define({ "api": [
  {
    "type": "get",
    "url": "/lbs/sync-worker",
    "title": "同步师傅数据",
    "description": "<p>同步师傅数据，将老系统mysql中的师傅数据导入定位系统postSql中,注：该接口使用时需要配置。</p>",
    "group": "LBS_Sync",
    "permission": [
      {
        "name": "LBS_TOKEN"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lbs_token",
            "description": "<p>认证秘钥</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "成功-Response:",
          "content": "{\n\"error\": 0,\n\"msg\": \"本次共同步了108003条数据，用时:9.46秒\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误-Response:",
          "content": "{\n\"error\": 1,\n\"msg\": \"导入失败\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/LbsApi/CopydataApiController.php",
    "groupTitle": "LBS_Sync",
    "name": "GetLbsSyncWorker"
  },
  {
    "type": "post",
    "url": "/lbs/insert-order",
    "title": "添加工单(json)",
    "description": "<p>添加工单(create post)</p>",
    "group": "Order_LBS",
    "permission": [
      {
        "name": "LBS_TOKEN"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lbs_token",
            "description": "<p>认证秘钥</p>"
          },
          {
            "group": "Parameter",
            "type": "BigInt",
            "optional": false,
            "field": "order_no",
            "description": "<p>工单编号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_desc",
            "description": "<p>工单描述</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "full_address",
            "description": "<p>联系人地址</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>联系人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "user_mobile",
            "description": "<p>联系人电话</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "merchant_id",
            "description": "<p>厂商id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "merchant_name",
            "description": "<p>厂商名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "merchant_tel",
            "description": "<p>厂商联系方式</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "user_lat",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "user_lng",
            "description": "<p>经度</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "published_at",
            "description": "<p>发布工单时间</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "big_cat",
            "description": "<p>大类</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "middle_cat",
            "description": "<p>中类</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "small_cat",
            "description": "<p>小类</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "order_type",
            "description": "<p>0保内/1保外</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": true,
            "field": "biz_type",
            "description": "<p>0安装/1维修</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n\"error\": 0,\n\"msg\": \"添加成功\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误例子:",
          "content": "{\n\"error\": 1,\n\"msg\": \"验证错误：未获得详细联系地址！(full_address),\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/LbsApi/OrderApiController.php",
    "groupTitle": "Order_LBS",
    "name": "PostLbsInsertOrder"
  },
  {
    "type": "post",
    "url": "/lbs/save-order",
    "title": "修改工单",
    "description": "<p>修改工单信息</p>",
    "group": "Order_LBS",
    "permission": [
      {
        "name": "LBS_TOKEN"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lbs_token",
            "description": "<p>认证秘钥</p>"
          },
          {
            "group": "Parameter",
            "type": "Bigint",
            "optional": false,
            "field": "order_id",
            "description": "<p>工单编号</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "state",
            "description": "<p>工单状态(0:未接单，1:已接单，2:已完成，3:已取消)</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "响应例子:",
          "content": "{\n\"error\": 0,\n\"msg\": \"修改成功\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误例子:",
          "content": "{\n\"error\": 1,\n\"msg\": \"验证错误：未输入工单编号(order_id),\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/LbsApi/OrderApiController.php",
    "groupTitle": "Order_LBS",
    "name": "PostLbsSaveOrder"
  },
  {
    "type": "get",
    "url": "/lbs/search-order",
    "title": "工单搜索(json)",
    "name": "shaozeming_xiaobaiyoupin_com",
    "description": "<p>针对师傅位置对指定范围的可接工单进行搜索</p>",
    "group": "Order_LBS",
    "permission": [
      {
        "name": "LBS_TOKEN"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lbs_token",
            "description": "<p>秘钥</p>"
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "user_lng",
            "description": "<p>经度</p>"
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "user_lat",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "dist",
            "description": "<p>搜索范围(米)，默认30000</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "limit",
            "description": "<p>返回最多条数</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "state",
            "description": "<p>订单状态(0:待接单，1:已接单)默认为0</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "biz_type",
            "description": "<p>0安装/1维修</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "small_cat",
            "description": "<p>小类 &quot;created_at&quot;: &quot;2017-03-20 18:36:31&quot;, &quot;updated_at&quot;: &quot;2017-03-20 18:36:31&quot;, &quot;dist&quot;: &quot;2223.90159469&quot; }, { &quot;id&quot;: &quot;4&quot;, &quot;order_no&quot;: &quot;1229282922&quot;, &quot;order_desc&quot;: &quot;不开机的&quot;, &quot;state&quot;: 0, &quot;order_type&quot;: 0, &quot;biz_type&quot;: 0, &quot;merchant_id&quot;: &quot;4&quot;, &quot;merchant_name&quot;: &quot;小米&quot;, &quot;merchant_tel&quot;: &quot;13330333876&quot;, &quot;user_id&quot;: &quot;232&quot;, &quot;user_name&quot;: &quot;少爷&quot;, &quot;user_mobile&quot;: &quot;18888888888&quot;, &quot;user_lat&quot;: &quot;39.33&quot;, &quot;user_lng&quot;: &quot;119.84&quot;, &quot;full_address&quot;: &quot;清华大学一栋28号&quot;, &quot;geom&quot;: &quot;0101000020E61000005D50DF32A7F55D40F46C567DAEAA4340&quot;, &quot;published_at&quot;: &quot;2017-03-20 23:34:33&quot;, &quot;big_cat&quot;: &quot;&quot;, &quot;middle_cat&quot;: &quot;&quot;, &quot;small_cat&quot;: &quot;&quot;, &quot;created_at&quot;: &quot;2017-03-20 18:38:13&quot;, &quot;updated_at&quot;: &quot;2017-03-20 18:38:13&quot;, &quot;dist&quot;: &quot;2223.90159469&quot; } ] } }</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "BigInt",
            "optional": false,
            "field": "order_no",
            "description": "<p>工单编号</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "dist",
            "description": "<p>距离(米)</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "order_desc",
            "description": "<p>工单描述</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "full_address",
            "description": "<p>联系人地址</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "user_name",
            "description": "<p>联系人姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "user_mobile",
            "description": "<p>联系人电话</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "merchant_id",
            "description": "<p>厂商id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "merchant_name",
            "description": "<p>厂商名称</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "merchant_telphone",
            "description": "<p>厂商联系方式</p>"
          },
          {
            "group": "Success 200",
            "type": "float",
            "optional": false,
            "field": "user_lat",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Success 200",
            "type": "float",
            "optional": false,
            "field": "user_lng",
            "description": "<p>经度</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "geom",
            "description": "<p>位置几何</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "published_at",
            "description": "<p>发布工单时间</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "big_cat",
            "description": "<p>大类</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "middle_cat",
            "description": "<p>中类</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "small_cat",
            "description": "<p>小类</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "order_type",
            "description": "<p>0保内/1保外</p>"
          },
          {
            "group": "Success 200",
            "type": "int",
            "optional": false,
            "field": "biz_type",
            "description": "<p>0安装/1维修</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>修改时间</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功响应例子:",
          "content": "{\n\"error\": 0,\n\"msg\": \"成功\",\n\"data\": {\n\"size\": 2,\n\"list\": [\n{\n\"id\": \"3\",\n\"order_no\": \"1229282922\",\n\"order_desc\": \"不开机的喂不了\",\n\"state\": 0,\n\"order_type\": 0,\n\"biz_type\": 0,\n\"merchant_id\": \"4\",\n\"merchant_name\": \"小米\",\n\"merchant_tel\": \"13330333876\",\n\"user_id\": \"232\",\n\"user_name\": \"小姐\",\n\"user_mobile\": \"18888888888\",\n\"user_lat\": \"39.33\",\n\"user_lng\": \"119.84\",\n\"full_address\": \"清华大学一栋28号\",\n\"geom\": \"0101000020E61000005D50DF32A7F55D40F46C567DAEAA4340\",\n\"published_at\": \"2017-03-19 00:00:00\",\n\"big_cat\": \"\",\n\"middle_cat\": \"\",\n\"small_cat\": \"\",",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "失败例子:",
          "content": "{\n\"error\": 1,\n\"msg\": \"\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/LbsApi/OrderApiController.php",
    "groupTitle": "Order_LBS"
  },
  {
    "type": "post",
    "url": "/lbs/insert-worker",
    "title": "添加师傅",
    "description": "<p>添加师傅位置信息</p>",
    "group": "Worker_LBS",
    "permission": [
      {
        "name": "LBS_TOKEN"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lbs_token",
            "description": "<p>认证秘钥</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "uid",
            "description": "<p>关联ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "full_address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>电话</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "worker_lat",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Parameter",
            "type": "float",
            "optional": false,
            "field": "worker_lng",
            "description": "<p>经度</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "成功-Response:",
          "content": "{\n\"error\": 0,\n\"msg\": \"添加成功\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误-Response:",
          "content": "{\n\"error\": 1,\n\"msg\": \"验证错误：该uid关联师傅已存在(uid),\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/LbsApi/WorkerApiController.php",
    "groupTitle": "Worker_LBS",
    "name": "PostLbsInsertWorker"
  },
  {
    "type": "post",
    "url": "/lbs/save-worker",
    "title": "修改师傅状态",
    "description": "<p>修改师傅信息</p>",
    "group": "Worker_LBS",
    "permission": [
      {
        "name": "LBS_TOKEN"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lbs_token",
            "description": "<p>认证秘钥</p>"
          },
          {
            "group": "Parameter",
            "type": "Bigint",
            "optional": false,
            "field": "uid",
            "description": "<p>关联id</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": false,
            "field": "state",
            "description": "<p>师傅状态(0:正常，1:锁定)</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "成功-Response:",
          "content": "{\n \"error\": 0,\n \"msg\": \"修改成功\",\n \"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "错误-Response:",
          "content": "{\n\"error\": 1,\n\"msg\": \"验证错误：未输入师傅关联id(uid),\",\n\"data\": []\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/LbsApi/WorkerApiController.php",
    "groupTitle": "Worker_LBS",
    "name": "PostLbsSaveWorker"
  },
  {
    "type": "get",
    "url": "/lbs/search-worker",
    "title": "搜索师傅",
    "name": "shaozeming_xiaobaiyoupin_com",
    "description": "<p>针对位置对附近师傅进行搜索</p>",
    "group": "Worker_LBS",
    "permission": [
      {
        "name": "LBS_TOKEN"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lbs_token",
            "description": "<p>认证秘钥</p>"
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "worker_lng",
            "description": "<p>经度</p>"
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "worker_lat",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "dist",
            "description": "<p>搜索范围(米)，默认30000</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "state",
            "description": "<p>状态(<code>0:正常,1:锁定</code>)，默认0</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "limit",
            "description": "<p>返回最多条数</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "BigInt",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID</p>"
          },
          {
            "group": "Success 200",
            "type": "BigInt",
            "optional": false,
            "field": "uid",
            "description": "<p>关联ID</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "dist",
            "description": "<p>距离(米)</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "full_address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>电话</p>"
          },
          {
            "group": "Success 200",
            "type": "float",
            "optional": false,
            "field": "worker_lat",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Success 200",
            "type": "float",
            "optional": false,
            "field": "worker_lng",
            "description": "<p>经度</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "geom",
            "description": "<p>位置几何</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "created_at",
            "description": "<p>创建时间</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "updated_at",
            "description": "<p>修改时间</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "成功-Response:",
          "content": "{\n\"error\": 0,\n\"msg\": \"成功\",\n\"data\": {\n\"size\": 2,\n\"list\": [\n{\n\"id\": \"108004\",\n\"name\": \"明明\",\n\"mobile\": \"13332425562\",\n\"state\": 0,\n\"worker_lat\": \"39.33\",\n\"worker_lng\": \"119.94\",\n\"full_address\": \"中关村五道口\",\n\"uid\": \"233334\",\n\"geom\": \"0101000020E6100000C3B645990DFC5D402D78D15790AA4340\",\n\"created_at\": \"2017-03-20 18:30:18\",\n\"updated_at\": \"2017-03-20 18:30:18\",\n\"st_astext\": \"POINT(119.93833 39.33253)\",\n\"dist\": \"0\"\n},\n{\n\"id\": \"1\",\n\"name\": \"明明\",\n\"mobile\": \"13332425562\",\n\"state\": 0,\n\"worker_lat\": \"39.33\",\n\"worker_lng\": \"158.94\",\n\"full_address\": \"中关村五道口\",\n\"uid\": \"1\",\n\"geom\": \"0101000020E6100000C3B645990DFC5D402D78D15790AA4340\",\n\"created_at\": \"2017-03-17 15:25:05\",\n\"updated_at\": \"2017-03-20 18:55:56\",\n\"st_astext\": \"POINT(119.93833 39.33253)\",\n\"dist\": \"0\"\n}\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/LbsApi/WorkerApiController.php",
    "groupTitle": "Worker_LBS"
  },
  {
    "type": "sql",
    "url": "/lbs/orders",
    "title": "工单表",
    "description": "<p>LBS系统工单表结构</p>",
    "group": "Z_Table_SQL",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "bigint",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID</p>"
          },
          {
            "group": "Parameter",
            "type": "tinyInt",
            "optional": false,
            "field": "state",
            "description": "<p>工单状态, 默认值：<code>0</code></p>"
          },
          {
            "group": "Parameter",
            "type": "bigint",
            "optional": false,
            "field": "order_no",
            "description": "<p>工单号,</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar",
            "optional": false,
            "field": "order_desc",
            "description": "<p>工单描述</p>"
          },
          {
            "group": "Parameter",
            "type": "tinyInt",
            "optional": false,
            "field": "order_type",
            "description": "<p>0保内/1保外, 默认值：<code>0</code></p>"
          },
          {
            "group": "Parameter",
            "type": "tinyInt",
            "optional": false,
            "field": "biz_type",
            "description": "<p>0安装/1维修, 默认值：<code>0</code></p>"
          },
          {
            "group": "Parameter",
            "type": "BigInt",
            "optional": false,
            "field": "merchant_id",
            "description": "<p>商家id</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar(64)",
            "optional": false,
            "field": "merchant_name",
            "description": "<p>厂商名称</p>"
          },
          {
            "group": "Parameter",
            "type": "char(12)",
            "optional": false,
            "field": "merchant_tel",
            "description": "<p>厂商联系方式</p>"
          },
          {
            "group": "Parameter",
            "type": "bigint",
            "optional": false,
            "field": "user_id",
            "description": "<p>联系人姓名, 默认值</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar(16)",
            "optional": false,
            "field": "user_name",
            "description": "<p>联系人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "char(12)",
            "optional": false,
            "field": "user_mobile",
            "description": "<p>联系人电话</p>"
          },
          {
            "group": "Parameter",
            "type": "decimal",
            "optional": false,
            "field": "user_lat",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Parameter",
            "type": "decimal",
            "optional": false,
            "field": "user_lng",
            "description": "<p>经度</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar(128)",
            "optional": false,
            "field": "full_address",
            "description": "<p>联系人地址</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar",
            "optional": false,
            "field": "big_cat",
            "description": "<p>大类,默认值:<code>&quot;&quot;</code></p>"
          },
          {
            "group": "Parameter",
            "type": "varchar",
            "optional": false,
            "field": "middle_cat",
            "description": "<p>中类,默认值:<code>&quot;&quot;</code></p>"
          },
          {
            "group": "Parameter",
            "type": "varchar",
            "optional": false,
            "field": "small_cat",
            "description": "<p>小类,默认值:<code>&quot;&quot;</code></p>"
          },
          {
            "group": "Parameter",
            "type": "geometry(Point)",
            "optional": false,
            "field": "geom",
            "description": "<p>位置坐标(注：字段类型为<code>geometry(Point,4326)</code>), 默认值：<code>NOT NULL</code></p>"
          },
          {
            "group": "Parameter",
            "type": "timestamp",
            "optional": false,
            "field": "published_at",
            "description": "<p>发布时间, 默认值：<code>NULL</code></p>"
          },
          {
            "group": "Parameter",
            "type": "timestamp",
            "optional": false,
            "field": "created_at",
            "description": "<p>创建时间, 默认值：<code>NULL</code></p>"
          },
          {
            "group": "Parameter",
            "type": "timestamp",
            "optional": false,
            "field": "updated_at",
            "description": "<p>修改时间, 默认值：<code>NULL</code></p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "创建表SQL语句:",
          "content": "\nCREATE TABLE orders (\nid bigint NOT NULL,\norder_no character varying(255) NOT NULL,\norder_desc character varying(255) NOT NULL,\nstate smallint DEFAULT '0'::smallint NOT NULL,\norder_type smallint DEFAULT '0'::smallint NOT NULL,\nbiz_type smallint DEFAULT '0'::smallint NOT NULL,\nmerchant_id bigint NOT NULL,\nmerchant_name character varying(64) NOT NULL,\nmerchant_tel character varying(12) NOT NULL,\nuser_id bigint NOT NULL,\nuser_name character varying(255) NOT NULL,\nuser_mobile character varying(12) NOT NULL,\nuser_lat numeric(8,2) NOT NULL,\nuser_lng numeric(8,2) NOT NULL,\nfull_address character varying(255) NOT NULL,\ngeom geometry(Point,4326) NOT NULL,\npublished_at timestamp(0) without time zone NOT NULL,\nbig_cat character varying(255) DEFAULT ''::character varying NOT NULL,\nmiddle_cat character varying(255) DEFAULT ''::character varying NOT NULL,\nsmall_cat character varying(255) DEFAULT ''::character varying NOT NULL,\ncreated_at timestamp(0) without time zone,\nupdated_at timestamp(0) without time zone\n);\n\nALTER TABLE orders OWNER TO postgres;\n\nCREATE SEQUENCE orders_id_seq\nSTART WITH 1\nINCREMENT BY 1\nNO MINVALUE\nNO MAXVALUE\nCACHE 1;\n\nALTER TABLE orders_id_seq OWNER TO postgres;\nALTER SEQUENCE orders_id_seq OWNED BY orders.id;\nALTER TABLE ONLY orders ALTER COLUMN id SET DEFAULT nextval('orders_id_seq'::regclass);\nALTER TABLE ONLY orders ADD CONSTRAINT orders_pkey PRIMARY KEY (id);\nCREATE INDEX orders_order_no_index ON orders USING btree (order_no);",
          "type": "sql"
        }
      ]
    },
    "filename": "app/Http/Controllers/sql.php",
    "groupTitle": "Z_Table_SQL",
    "name": "SqlLbsOrders"
  },
  {
    "type": "sql",
    "url": "/lbs/workers",
    "title": "师傅表",
    "description": "<p>LBS系统师傅表结构</p>",
    "group": "Z_Table_SQL",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "bigint",
            "optional": false,
            "field": "id",
            "description": "<p>主键ID</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar",
            "optional": false,
            "field": "name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "char(12)",
            "optional": false,
            "field": "mobile",
            "description": "<p>电话</p>"
          },
          {
            "group": "Parameter",
            "type": "varchar",
            "optional": false,
            "field": "full_address",
            "description": "<p>地址</p>"
          },
          {
            "group": "Parameter",
            "type": "bigint",
            "optional": false,
            "field": "uid",
            "description": "<p>关联ID</p>"
          },
          {
            "group": "Parameter",
            "type": "decimal",
            "optional": false,
            "field": "worker_lat",
            "description": "<p>纬度</p>"
          },
          {
            "group": "Parameter",
            "type": "decimal",
            "optional": false,
            "field": "worker_lng",
            "description": "<p>经度</p>"
          },
          {
            "group": "Parameter",
            "type": "geometry(Point)",
            "optional": false,
            "field": "geom",
            "description": "<p>地址(注：字段类型为<code>geometry(Point,4326)</code>)：(<code>NOT NULL</code>)</p>"
          },
          {
            "group": "Parameter",
            "type": "tinyInt",
            "optional": false,
            "field": "state",
            "description": "<p>工单状态(0:正常，1:锁定),默认值：<code>0</code></p>"
          },
          {
            "group": "Parameter",
            "type": "timestamp",
            "optional": false,
            "field": "created_at",
            "description": "<p>创建时间,默认值：<code>NULL</code></p>"
          },
          {
            "group": "Parameter",
            "type": "timestamp",
            "optional": false,
            "field": "updated_at",
            "description": "<p>修改时间,默认值：(<code>NULL</code>)</p>"
          }
        ]
      }
    },
    "version": "0.1.0",
    "success": {
      "examples": [
        {
          "title": "创建SQL语句:",
          "content": "\nCREATE TABLE workers (\nid bigint NOT NULL,\nname character varying(100) NOT NULL,\nmobile character varying(12) NOT NULL,\nstate smallint DEFAULT '0'::smallint NOT NULL,\nworker_lat numeric(8,2) NOT NULL,\nworker_lng numeric(8,2) NOT NULL,\nfull_address text NOT NULL,\nuid bigint DEFAULT '0'::bigint NOT NULL,\ngeom geometry(Point,4326) NOT NULL,\ncreated_at timestamp(0) without time zone,\nupdated_at timestamp(0) without time zone\n);\nALTER TABLE workers OWNER TO postgres;\nCREATE SEQUENCE workers_id_seq\nSTART WITH 1\nINCREMENT BY 1\nNO MINVALUE\nNO MAXVALUE\nCACHE 1;\n\nALTER TABLE workers_id_seq OWNER TO postgres;\nALTER SEQUENCE workers_id_seq OWNED BY workers.id;\nALTER TABLE ONLY workers ALTER COLUMN id SET DEFAULT nextval('workers_id_seq'::regclass);\nALTER TABLE ONLY workers ADD CONSTRAINT workers_pkey PRIMARY KEY (id);\nCREATE INDEX workers_uid_index ON workers USING btree (uid);",
          "type": "sql"
        }
      ]
    },
    "filename": "app/Http/Controllers/sql.php",
    "groupTitle": "Z_Table_SQL",
    "name": "SqlLbsWorkers"
  }
] });
