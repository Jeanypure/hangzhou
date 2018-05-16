
DROP TABLE IF EXISTS  `pur_info`;
CREATE TABLE `pur_info` (
`pur_info_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
`purchaser` int(11) DEFAULT '0' COMMENT '开发负责人',
`pur_group` int(11) DEFAULT '0' COMMENT '序号',
`pd_title` varchar(100) DEFAULT NULL COMMENT '中文简称',
`pd_title_en` varchar(100) DEFAULT NULL COMMENT '英文全称',
`pd_pic_url` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '图片',
`pd_package` varchar (1000) default NULL  COMMENT '外包装',
`pd_length` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '长cm',
`pd_width` varchar(10) DEFAULT NULL COMMENT '宽cm',
`pd_height` varchar(10) DEFAULT NULL COMMENT '高cm',
`is_huge` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否大件 0 否 1 是',
`pd_weight` decimal(10,3) DEFAULT '0.000' COMMENT '货物实际重量kg',
`pd_throw_weight` decimal(10,3) DEFAULT '0.000' COMMENT '抛重 长*宽*高/6000',
`pd_count_weight` decimal(10,3) DEFAULT '0.000' COMMENT '计算重量',
`pd_material` varchar (1000) default NULL  COMMENT '材质',
`pd_purchase_num` int(11) NOT NULL DEFAULT '1' COMMENT '申请采购数量',
`pd_pur_costprice` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '含税价格',
`has_shipping_fee` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否含运 0 否 1 是',
`bill_type` varchar(10) default null COMMENT '开票类型  --普票-- --专票--',
`bill_tax_value`  tinyint(4) default null  comment '开票税率 --数字 并且小于16',
`hs_code`  int(11) default null  comment 'HS编码',
`bill_tax_rebate`  tinyint(4) default null  comment '退税率',
`bill_rebate_amount`  varchar(30) default null  comment '退税金额',
`no_rebate_amount`  varchar(30) default null  comment '预计销售不退税价格RMB',
`retail_price`  varchar(30) default null  comment '预计销售价格$',
`ebay_url` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'eBay最低价链接',
`amazon_url` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'amazon最低价链接',
`url_1688` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' COMMENT '1688最低价链接',
`shipping_fee`  varchar(30) default null  comment '海运运费预估',
`oversea_shipping_fee`  varchar(30) default null  comment '海外仓运运费预估',
`transaction_fee`  varchar(30) default null  comment '成交费 销售金额的13%',
`gross_profit`  varchar(30) default null  comment '预估毛利',
`remark` varchar(100) default null  COMMENT '备注',
`parent_product_id` int(11) DEFAULT '0' COMMENT '关联的母SKU ID',
PRIMARY KEY (`pur_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3787 DEFAULT CHARSET=utf8 COMMENT='采购信息表';


