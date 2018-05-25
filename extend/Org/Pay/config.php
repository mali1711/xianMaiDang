<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2018052460238314",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEpQIBAAKCAQEAv/bfa/NikOeB7EnQoHzDtaBKZyr6XDOlr3ucFwzahZHznahu2OCga+eopKKBdj25kANqNiEP86p3/k9R2MQJsAsdUClxkCvFbnu7ZnsKvYxI/UrytqGB5kO7CRrTQ84UUMeso301xI1L4If+JutDXMl9dKvPkS2vhtNpYYJIrUaAMGu4KCaPUltQqAITdXPBj6+Ie/16FScXptbI1HPfu5QXMPut9F3lFdLeHE60E6ywjj3jaTPEtHzFNEaE48qO6Zx94OQBUs5aAlJ4sYVimzh/9ZUrwjcV6qiXLguX4Uc5TtvyUOA9kCEIihYgWfnD78rNbJrXWwyM6759767TFQIDAQABAoIBAQCzugCegmXjQ01KHCYfTBC0SRnAE+YJUzWp4bJXhmpFqkuLbXoyxcSMon0rfxZ0zP+iTQAxI61atlzYFg2MRKbJUu6j8dloYQLdGS1wmnyI0QI5W+V4hignnXxM3vezwQsWQoxpGT6xApVq6AhVCemswt0Z0g5pX3u6YM+GQsOmrfyKb8ujHnUxs/jgjRJMgh2N+PE4SpPhQUuK+R3MODa5m7sPIpoTtay52kNpHoN9OHsFjdNUulrGAY8dIKHGUf2Lw86ajA8ghfmdbhEaRKhZImFZRko1Mz/xbpNv+V4/+AncX8Y3MyNSQnUWPGlwxN+BuQ5lYj+UVKCe296vt8HVAoGBAPefixxYDBUNOSBPB6dA2lcAf1NABiditKaGOeKUidLS8FMqIgS2q6bDPnTPa6TUmUIUldL8a+SX2rpYsEot5tIg1WH+oJjZpqJM7t83Guvecsr5FpXU16tD+YHUF8ZzJTgBppgZd+IufaMeZZbQmlGwLfTwuY4th1yv8Ig3azgPAoGBAMZ1UIwuHl+Ed2LiAlNMpEnlIxXvBQlGpVbJkgT0lfK3dNBEuZJzigN69UAaTt63g5QQ+SnJBCPqmVWoXb83/tUBNpRP3QZEMGY5dMc9xS9dcH0LDGqdKkIoSkWZplLFKKsy6JlIdCH/+zTSA5tAOZ/bK2mKO9fHsppHnBZwi/6bAoGBAMCBGr+lP3daOVABwHxpMZSzgUiyHFagKLrQ3M1mFqN8c3Lj7WBmtplFbheXbSLOWHsDz9offK1Q1K1L53kzqB8xgVHWhvltM1s3nfiQOXCnFezvqnw+5I9zn9Qrk3Qm7gdVWTMjkYyYAfo+1lFhyKa65W9neYmroXEQIllzY/pHAoGBAMJLZJp5JF9bbw6uOpyW8lkuLhVxNrsIISNAoOadFpjUJ1cnkY7h8wLJRIaHuyOtAvLZUzcniBgpvAjylyV4itK7J1Y4gil6ZPAP3FacEQr4LgMd6AAQ8qhmjaBqdz2drN0/MB2xo5EN7kCeQ82hKUlp56yiG0h8SE1nQldtxIF1AoGABkuPcONCu12/I74u9kj4vnUdzz0k9rfkWRGD1I54sBYoCPvWK9vrarn2shbr7DLVPi1y2E0HnwaC4kqqVW8wWJ2jqhSaTxHOIIzPsQ04zeEHK6BbIby7EK3IpoW6OhSyYS5g7yUWfn1717g8WlKsOr6PlsHeEym5y+AXggUbwqA=",
		
		//异步通知地址
		'notify_url' => "http://mitsein.comalipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://mitsein.com/alipay.trade.wap.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAv/bfa/NikOeB7EnQoHzDtaBKZyr6XDOlr3ucFwzahZHznahu2OCga+eopKKBdj25kANqNiEP86p3/k9R2MQJsAsdUClxkCvFbnu7ZnsKvYxI/UrytqGB5kO7CRrTQ84UUMeso301xI1L4If+JutDXMl9dKvPkS2vhtNpYYJIrUaAMGu4KCaPUltQqAITdXPBj6+Ie/16FScXptbI1HPfu5QXMPut9F3lFdLeHE60E6ywjj3jaTPEtHzFNEaE48qO6Zx94OQBUs5aAlJ4sYVimzh/9ZUrwjcV6qiXLguX4Uc5TtvyUOA9kCEIihYgWfnD78rNbJrXWwyM6759767TFQIDAQAB
",
		
	
);