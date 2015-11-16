# CodeIgniter-Smarty-Email-Template
在CI和Smarty的基础上扩展邮件模板，在开发中让html和php后端数据分离

修改Smarty 模板
\www\application\home\libraries\Smarty\sysplugins\smarty_internal_templatebase.php
添加代码：
```php
    public function display2($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        return $this->fetch($template, $cache_id, $compile_id, $parent, false);
    }
```

参数
```php
$emailtemplate = array(
    //邮件
    'email'=>'email/notification.html',         //email html path
    'subject'=>'Etekcitizen Program: Application ACCEPT!'     //email subject
);
```

```php
$info = array(
    "user_name"=>$orderArr['fullname'],
    "data"=>$data,
    "to"=>$orderArr['email']
  );
```

###Demo

在任何需要调用的地方
```php
$info = array(
    "user_name"=>'Tim',
    "data"=>$data,
    "to"=>'email@email.com'
  );
$this->load->service('s_email');
$resCode = $this->s_email->sendEmail($info,$emailtemplate);
```

Email 模板
views/email/notification.html
```html
Hi 
<{$user_name}>
<p>
	This is Email Html!
<p/>
<{$data}>
```
