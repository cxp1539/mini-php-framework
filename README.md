#Temptation Framework

## Framework

自己闲来无事写的一款php framework......

## Framework特点

> 1.    单入口index.php
> 2.    采用面向对象思想，基于MVC设计思想，使用观察者，注册器，工厂，代理，trait特性等模式开发。
> 3.    使用namespace命名空间。
> 4.    autoLoader自动加载类。
> 5.    debug，Profiler(性能分析器)。
> 6.    提供一些常用类(图片,分页,文件上传,验证码等)。
> 7.    提供grunt常用的插件(文件压缩,合并,观察等)。
> 8.    基于ArrayAccess通过数组下标访问配置文件。
> 9.    obcache缓存。

##项目目录结构
```
classes         公共的类文件存
    --image.class.php           图片操作类
    --logobserver.class.php     观察者log实现类
    --page.class.php            分页类
    --upload.class.php          文件上传类
    --vcode.class.php           验证码类
conf            配置文件
    --database.php              数据库配置
    --memcache.php              memcached配置
controls        控制器
intef           基础接口或者抽象类
    --db.class.php              数据库接口规范
    --observer.class.php        异常观察者接口规范
libs            默认加载库文件
    --action.class.php          调用控制器和方法类
    --autoloader.class.php      自动加载类
    --config.class.php          读取配置文件类
    --controller.class.php      控制器基类
    --debug.class.php           debug调试类
    --factory.class.php         工厂类
    --globalf.class.php         全局函数类
    --memcached.class.php       memcached实现类
    --mysqli.class.php          mysqli实现类
    --obcache.class.php         obcache缓存类
    --obexception.class.php     自定义异常处理类
    --profiler.class.php        性能分析类
    --proxy.class.php           代理类
    --register.class.php        注册器类
    --singleton.class.php       单例trait
    --url.class.php             url请求处理类    
node_modules    node插件
    grunt-contrib-concat        grunt文件合并插件
    grunt-contrib-uglify        grunt文件压缩插件
    grunt-contrib-watch         grunt文件观察插件     
    grunt                       grunt插件
statics         静态资源目录
    js                          js
    release_js                  grunt处理后的js
    css                         css
    images                      images
    uploads                     图片上传目录
vies            模版目录
Gruntfile.js    grunt配置文件
README.md       README.md
common.inc.php  核心文件
    1.定义字符集
    2.设置时区
    3.开启session
    4.定义主目录和静态资源目录常量
    5.autoLoader
    6.url获取调用控制器和方法
    7.debug，Profiler开启(性能分析器)
    8.初始化接收的控制器和方法处理action请求(反射机制)
    9.debug，Profiler接口，输出debug信息,执行时间,使用内存等。
index.php       主入口
package.json    package.json
```