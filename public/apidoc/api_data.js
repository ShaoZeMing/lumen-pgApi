define({ "api": [
  {
    "type": "post",
    "url": "/lbs/insert-order",
    "title": "添加工单",
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
            "allowedValues": [
              "'(-180.00000,-90.000000) ~ (180.00000,90.000000) '"
            ],
            "optional": false,
            "field": "geom",
            "description": "<p>位置坐标，格式 <code>&quot;精度，纬度&quot;</code></p>"
          },
          {
            "group": "Parameter",
            "type": "BigInt",
            "optional": false,
            "field": "order_id",
            "description": "<p>工单ID编号</p>"
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
            "type": "String",
            "optional": false,
            "field": "merchant_name",
            "description": "<p>厂商名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "merchant_telphone",
            "description": "<p>厂商联系方式</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "description",
            "description": "<p>工单描述</p>"
          },
          {
            "group": "Parameter",
            "type": "BigInt",
            "optional": true,
            "field": "category_id",
            "description": "<p>分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "category_name",
            "description": "<p>分类名称</p>"
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
          "content": "{\n\"error\": 1,\n\"msg\": \"验证错误：工单编号已存在(order_id),\",\n\"data\": []\n}",
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
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "order_id",
            "description": "<p>工单编号</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "state",
            "description": "<p>工单状态(0:未接单，1:已接单，2:已完成，3:已取消)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "full_address",
            "description": "<p>联系人地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "user_name",
            "description": "<p>联系人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "user_mobile",
            "description": "<p>联系人电话</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "merchant_name",
            "description": "<p>厂商名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "merchant_telphone",
            "description": "<p>厂商联系方式</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "description",
            "description": "<p>工单描述</p>"
          },
          {
            "group": "Parameter",
            "type": "BigInt",
            "optional": true,
            "field": "category_id",
            "description": "<p>分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "category_name",
            "description": "<p>分类名称</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'(-180.00000,-90.000000) ~ (180.00000,90.000000) '"
            ],
            "optional": true,
            "field": "geom",
            "description": "<p>位置坐标，格式 <code>&quot;精度，纬度&quot;</code></p>"
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
    "title": "工单搜索",
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
            "allowedValues": [
              "'(-180.00000,-90.000000) ~ (180.00000,90.000000) '"
            ],
            "optional": false,
            "field": "geom",
            "description": "<p>位置坐标，格式 <code>&quot;精度，纬度&quot;</code></p>"
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
            "description": "<p>返回条数</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "order_status",
            "description": "<p>订单状态(0:待接单，1:已接单，2:已完成，4:已取消)默认为0</p>"
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
            "field": "order_id",
            "description": "<p>工单ID编号</p>"
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
            "description": "<p>联系人地址</p>"
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
            "type": "String",
            "optional": false,
            "field": "description",
            "description": "<p>工单描述</p>"
          },
          {
            "group": "Success 200",
            "type": "BigInt",
            "optional": false,
            "field": "category_id",
            "description": "<p>分类id</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "category_name",
            "description": "<p>分类名称</p>"
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
          "title": "成功响应例子:",
          "content": "{\n\"error\": 0,\n\"msg\": \"成功\",\n\"data\": {\n\"size\": 3,\n\"list\": [\n{\n\"id\": \"1\",\n\"order_id\": \"12315\",\n\"description\": \"电视坏了，快来修\",\n\"state\": 0,\n\"merchant_name\": \"小米科技\",\n\"merchant_telphone\": \"0103456789\",\n\"category_id\": \"4\",\n\"category_name\": \"家电\",\n\"user_name\": \"流沙\",\n\"user_mobile\": \"15196566135\",\n\"full_address\": \"五道口家园\",\n\"geom\": \"0101000020E61000007B319413ED8E5E4059C0046EDD9D4640\",\n\"created_at\": \"2017-03-16 18:17:17\",\n\"updated_at\": \"2017-03-16 18:17:17\",\n\"dist\": \"0\"\n},\n{\n\"id\": \"2\",\n\"order_id\": \"123152\",\n\"description\": \"电视坏了，快来修\",\n\"state\": 0,\n\"merchant_name\": \"小米科技\",\n\"merchant_telphone\": \"0103456789\",\n\"category_id\": \"4\",\n\"category_name\": \"家电\",\n\"user_name\": \"明月\",\n\"user_mobile\": \"15196986655\",\n\"full_address\": \"峨眉清风塔\",\n\"geom\": \"0101000020E6100000895E46B1DC8E5E403A3B191C259F4640\",\n\"created_at\": \"2017-03-16 18:18:03\",\n\"updated_at\": \"2017-03-16 18:18:03\",\n\"dist\": \"1114.70414013\"\n},\n{\n\"id\": \"3\",\n\"order_id\": \"1231524\",\n\"description\": \"冰箱坏坏了，快来修\",\n\"state\": 0,\n\"merchant_name\": \"小米科技\",\n\"merchant_telphone\": \"0103456789\",\n\"category_id\": \"4\",\n\"category_name\": \"家电\",\n\"user_name\": \"明月\",\n\"user_mobile\": \"15194586135\",\n\"full_address\": \"蜀山\",\n\"geom\": \"0101000020E61000009EEA909BE18E5E406553AEF02E9F4640\",\n\"created_at\": \"2017-03-16 18:18:40\",\n\"updated_at\": \"2017-03-16 18:18:40\",\n\"dist\": \"1146.6200287\"\n}\n]\n}\n}",
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
            "allowedValues": [
              "'(-180.00000,-90.000000) ~ (180.00000,90.000000) '"
            ],
            "optional": false,
            "field": "geom",
            "description": "<p>位置坐标，格式 <code>&quot;精度，纬度&quot;</code></p>"
          },
          {
            "group": "Parameter",
            "type": "BigInt",
            "optional": false,
            "field": "uid",
            "description": "<p>师傅ID编号</p>"
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
    "url": "/lbs/insert-worker",
    "title": "修改师傅",
    "description": "<p>修改师傅信息</p>",
    "group": "Worker_LBS",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "uid",
            "description": "<p>师傅uid</p>"
          },
          {
            "group": "Parameter",
            "type": "Int",
            "optional": true,
            "field": "state",
            "description": "<p>师傅状态(0:未接单，1:已接单，2:已完成，3:已取消)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "full_address",
            "description": "<p>师傅地址</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "user_name",
            "description": "<p>师傅姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "mobile",
            "description": "<p>师傅电话</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "allowedValues": [
              "'(-180.00000,-90.000000) ~ (180.00000,90.000000) '"
            ],
            "optional": true,
            "field": "geom",
            "description": "<p>位置坐标，格式 <code>&quot;精度，纬度&quot;</code></p>"
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
    "name": "PostLbsInsertWorker"
  },
  {
    "type": "get",
    "url": "/lbs/search-worker",
    "title": "搜索师傅",
    "name": "shaozeming_xiaobaiyoupin_com",
    "description": "<p>针对师傅位置对师傅进行搜索</p>",
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
            "allowedValues": [
              "'(-180.00000,-90.000000) ~ (180.00000,90.000000) '"
            ],
            "optional": false,
            "field": "geom",
            "description": "<p>位置坐标，格式 <code>&quot;精度，纬度&quot;</code></p>"
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
            "description": "<p>返回条数</p>"
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
            "field": "uid",
            "description": "<p>师傅ID编号</p>"
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
            "description": "<p>联系人地址</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>联系人姓名</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>联系人电话</p>"
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
          "content": "{\n\"error\": 0,\n\"msg\": \"成功\",\n\"data\": {\n\"size\": 3,\n\"list\": [\n{\n\"id\": \"4\",\n\"name\": \"近平先生\",\n\"mobile\": \"15884565443\",\n\"state\": 0,\n\"full_address\": \"中关村创业大街123号\",\n\"uid\": \"67\",\n\"geom\": \"0101000020E610000060EAE74D45905E40EE42739D469E4640\",\n\"created_at\": \"2017-03-16 18:58:36\",\n\"updated_at\": \"2017-03-16 18:58:36\",\n\"st_astext\": \"POINT(122.25423 45.23653)\",\n\"dist\": \"1097.49543698\"\n},\n{\n\"id\": \"3\",\n\"name\": \"雷军\",\n\"mobile\": \"15444565443\",\n\"state\": 0,\n\"full_address\": \"华清家园\",\n\"uid\": \"12\",\n\"geom\": \"0101000020E61000007E6FD39FFD8E5E404451A04FE49D4640\",\n\"created_at\": \"2017-03-16 18:57:38\",\n\"updated_at\": \"2017-03-16 18:57:38\",\n\"st_astext\": \"POINT(122.23423 45.23353)\",\n\"dist\": \"2121.35513343\"\n},\n{\n\"id\": \"2\",\n\"name\": \"弥勒法\",\n\"mobile\": \"1333333333\",\n\"state\": 0,\n\"full_address\": \"少林寺\",\n\"uid\": \"234\",\n\"geom\": \"0101000020E61000007E6FD39FFD8E5E407D96E7C1DD9D4640\",\n\"created_at\": \"2017-03-16 18:56:40\",\n\"updated_at\": \"2017-03-16 18:56:40\",\n\"st_astext\": \"POINT(122.23423 45.23333)\",\n\"dist\": \"2136.42281823\"\n}\n]\n}\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/LbsApi/WorkerApiController.php",
    "groupTitle": "Worker_LBS"
  }
] });