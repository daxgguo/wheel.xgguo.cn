<?php
1,查看当前操作目录的内容
>dir

2,查看当前操作目录的内容
>ls    			//list
>ls -l 			//显示文件具体信息
>ls -al or ll 	//显示文件具体信息(包括隐藏文件)
>ls -a  		//显示文件全部目录(没显示详细信息，但显示隐藏文件)
>ls -al [目录名称]	//查看指定目录信息
>ls -li [目录名称]	//查看指定目录信息(包括文件索引号)

3,查看当前目录路径的位置
>pwd

4,目录的切换
>cd 目录名字
>cd ..  cd ../			//上级目录
>cd .  cd ./			//当前目录
>cd ~  					//回到家目录（不管现在在哪个位置）

5,用户切换
>su -  or  su -root     //切换到超级管理员
>su 普通用户名
>exit 					//退出到原来的用户

6，查看当前用户
>whoami       //显示当前操作系统的用户
>who am i 	  //显示登陆该系统的用户信息

7,图形界面 和 命令界面 的切换
># init 3		//切换到 命令界面
># init 5		//切换到图形界面

8,查看指令的可执行文件的位置
>which  指令			//返回的是该指令的存放的文件目录

9,直接打印文件内容到终端
>cat 文件

10,目录操作
	1) 目录创建
		>mkdir 目录  //创建目录
	   	>mkdir oldDir/oldDir/newDir    //创建多级目录
	   	>mkdir -p newDir/newDir/newDir   //创建多级目录
	   	>mkdir /home/xgguo/guangdong     //绝对路径创建目录
	2) 移动目录  move
		>mv dir1 dir2   //dir1 移动到 dir2目录下
	3) 目录改名
		>mv dir1 newDir     //dir1改名为newDir
	4) 复制 copy
		>cp -R dir1 dir2     //把目录dir1复制到目录dir2目录下，-----R递归（recursive）
		>cp dir/file dir2    //复制文件file到目录dir2下
	5) 删除 remove
		>rm file 			//删除file文件
		>rm -r dir          //删除目录
		>rm -rf filename    //递归强制删除目录（文件） --- -f  force强制的
		>rm -rf /           //强制递归删除根目录

11,清空屏幕
>clear

12,文件简单操作
	1) 文件内容查看
		>cat filename           //一次性显示全部内容
		>more filename          //通过回车查看逐行文件,Q键结束查看
		>less filename          //'上下左右'键的方式查看内容（支持回看）

		>head -n filename       //查看文件的前n行内容
		>tail -n filename       //查看文件的最后的n行内容
		>wc filename            //查看文件内容的行数
	2) 创建文件
		>touch filename         //当前目录创建文件
		>touch dir/filename     //指定目录创建文件
	3) 文件添加内容
		>echo 内容 > 文件       //把内容以覆盖写的方式添加到文件中，不存在的文件就自动创建
		>echo 内容 >> 文件       //把内容以追加的方式添加到文件中，不存在的文件就自动创建




13,用户操作
		1) 创建useradd
			对应配置文件：/etc/passwd
			># useradd -g 组编号 -d 家目录 -u 用户编号 用户名
		2) 修改usermod
			># usermod -g 组编号 -d 家目录(手动创建) -u 用户编号 -l newname 用户名
		3) 删除userdel
			># userdel -r 用户名    //删除用户信息同时删除'家目录'

14,组的操作
		1) 创建groupadd
			对应配置文件：etc/group
			># groupadd 组名
		2) 修改groupmod
			># groupmod -g 本身组ID -n newgroupname 组名
		3) 删除groupdel
			># groupdel 组名         	//如果该组存在用户，不能够删除，必须全部移除


15，查看指令可以使用的参数
>man 指令

16,为用户添加密码
>passwd 用户名

17,查看登陆记录
>who


18,编辑模式操作
	>vi filename    //查看文件
	>退出查看:先进入尾行模式，q退出   :q

	命令模式 与 编辑模式
	a:光标向后移动以为进入编辑模式
	i:光标不移动，内容没变化进入编辑模式
	o:新起一行进入编辑模式
	s:删除光标所在字符进入编辑模式

	退出编辑模式：
	>按键"esc"

19,尾行模式操作
	:w     //对编辑后的文档进行保存
	:q     //退出编辑器
	:wq    //保存并退出编辑器
	:q!    //强制退出
	:w!    //强制保存
	:wq!   //强制保存并退出

	:set number  或 nu         //给编辑器设置行号
	:set nonumber   或 nonu    //给编辑器取消行号

	:n(数字)        //光标定义到第几行
	:/内容/   或  /内容          //查找内容（n下一个 N上一个）

	//内容替换
	:s/cont1/cont2/              //cont1 替换为 cont2 ,替换光标所在行的第一个目标
	:s/cont1/cont2/g             //cont1 替换为 cont2 ,替换光标所在行的全部目标
	:%s/cont1/cont2/g             //cont1 替换为 cont2 ,替换文档的全部目标

20,命令模式的操作
	1) 光标的移动
		>上(k)下(j)左(h)右(l)键				//字符级的移动
		>单词级
			w:word下个单词首字母
			b:上个单词首字母
			e:下个单词尾字母
		>行级
			$:定位到行尾
			0:定位到行首
		>段落级
			}:下个段落尾部
			{:上个段落首部
		>屏幕级
			H:当前屏幕首部
			L:当前屏幕尾部
		>文档级
			G:文档尾部
			1G:文档首部
			nG:文档第N行
21,删除内容
	dd       //删除光标当前行
	n+dd     //向后删除N行内容(包括当前行)
	x        //删除光标所在的字符
	c+w      //从光标所在位置删除单词结尾（快速进入编辑模式）
22,复制内容
	yy:复制光标所在行
	n+yy:向后复制n行内容（包括本行）
	p:对复制的内容进行粘贴
24,快捷操作
	r+字符       //快速替换单个字符
	u            //撤销undo
	.            //点，重复执行上一次命令
	J            //大J,合并两行

26,权限操作
	1) 字母相对方式设置权限
		>chmod u+/rwx,g+/rwx,o+/rwx filename     //添加或者删除文件权限
		>chmod u+r,u-x fielname                  //同时添加并删除权限
		>chmod +w,-x filename                    //统一为各组设置统一的权限
	2) 数字绝对方式设置权限
		0------>没有权限
		1------>执行
		2------>写
		3------>写、执行
		4------>读
		5------>读、执行
		6------>读、写
		7------>读、写、执行

		>chmod ABC filename      //ABC代表主人、同组、其他组用户的权限数字

27,在指定文件中搜索内容
	>grep 被搜索内容 文件 			//将本文本中指定的信息匹配出来
	>which 指令 					//查找指令对应的二进制文件
	>ps -A                          //查看系统的活跃进程
	>du -h 目标						//以K、M、G为单位显示目录或文件所占据磁盘空间大小block
	>date 							//查看系统时间
	>date -s "2015-12-05 12:00:01"  //设置系统时间
	>df -lh 						//查看系统分区情况
	>kill -9 pid 					//杀死指定进程号的进程

28,linux的管道
	其中的许多命令（grep head tail wc ls 等）都可以当做管道符号使用
	1) ls -l | wc                   		//计算当前目录文件的行数
	2) ls -l | head -5              		//列出当前目录的前5行文件
	3) ls -l | head -30 | -5        		//列出当前目录的25-30的文件
	4) grep this apple.txt | grep was    	//在apple.txt文件中查找一行，该行即出现this字样，还出现was字样

29,文件查找find
>find 被查找的目录 选项 选项值[选项 选项值 选项 选项值 选项 选项值]
具体选项：
	-name filename               		//直接根据文件名查找
		>find / -name passwd 			//在根目录把系统全部目录遍历查找名字为：passwd的文件
		>find ./ -name "o*" 			//在当前目录下模糊查找o字符作为开始内容文件
	-size 大小 							//根据文件大小查找
		单位：默认512字节
			100c  //字节单位（100*1）
			12k   //千字节单位（12*1024）
			35    //512字节（35*512）
			5m    //兆单位（5*1024*1024）
			>find ./ -size 35c          //查找大小为35*1个字节的文件
			>find ./ -size +7k          //大于7k的文件


	-maxdepth 层次 						//限制最深层次查找
	-mindepth 层次 						//限制最浅层次查找
	-perm 权限 							//查找符合某个权限的文件
	-user username   					//通过主人名字查找文件
	-group groupname 					//通过祖名字查找文件
	-type f/d 							//根据"文件/目录"查找

30,软链接
	>ln -s 源文件/文件夹 软链接名字
	//如果软链接与源文件不在同一个目录下，源文件需要设置为绝对路径

31,硬链接
	>ln [-d] 源文件 硬链接名字
	//源文件不需要使用绝对路径
	//普通文件可以设置硬链接，目录不可以
	//同一个源文件的所有硬链接文件必须在同一个硬盘、同一个分区里面

32,任务调度指令设置
	>crontab -e       //编辑任务调度指令
	>crontab -l       //查看任务调度指令
	具体使用：
	#分钟 小时 日期 月份 星期 指示命令
	   43   21   *    *    *   			每天的21点43分执行一次
	    0   17   *    *    1   			每周一的17点0分执行一次
	   42    4   1    *    *   			每月的4点42分执行一次
	    0   21   *    *    1-6 			周一到周六的每天21点0分执行一次
	    2  8-20/3 *   *    *   			每天的08:02,11.02,14.02,17.02,20.02执行一次(每隔3小时执行一次)
	   30    5  1,15  *    *   			每月的1号，15号的5:50分执行一次


33,文件主人，组别设置
	change owner
	>chown 主人 filename
	>chown 主人.组别 filename
	>chown .组别 filename
	>chown -R 主人.组别 dirname 		//递归方式设置目录的组属
	>chown -R 777 dirname 				//递归方式设置目录的权限


34,启动网络
service network start/stop/restart


35,光驱挂载
	>mount /dev/cdrom(硬件)     /home/xgguo/rom(挂载点)  			//挂载动作
	>umount /dev/cdrom     											//(硬件)卸载光驱
	>umount /home/xgguo/rom 										//(挂载点)卸载光驱
	>eject 															//弹出光盘



36,系统软件的安装
	A  二进制软件安装
		1) rpm方式
			>rpm -ivh 软件包全名 					//安装并显示更详细的信息
			>rpm -q 软件包名(完整) 					//查看是否安装该软件
			>rpm -e 软件包名 						//卸载该软件
			>rpm -qa 								//查看系统中全部rpm安装的软件
			>rpm -qa | grep ftpd  					//模糊查找指定软件是否安装
		2) yum智能方式
	B  源码编译方式


37,启用ftp软件
	>service vsftpd start/stop/restart 
	>ps -A | grep ftp  						//查看进程
	//首次启动ftp:关闭防火墙，配置selinux


38,防火墙
systemctl start firewalld.service 					#启动firewall
systemctl stop firewalld.service 					#停止firewall
systemctl disable firewalld.service 				#禁止firewall开机启动



38,selinux
配置ftp需要关闭selinux
//修改配置文件需要重启机器：
//修改/etc/selinux/config 文件
//将SELINUX=enforcing改为SELINUX=disabled
//重启机器即可

39,解压
	.tar.gz-----------------tar zxvf 压缩包.tar.gz
	.tar.bz2-----------------tar jxvf 压缩包.tar.bz2



40,源码方式安装
	1) 解压文件
	2) ./configure 			//配置安装选项
	3) make 				//根据configure配置项生成二进制文件
	4) make install 		//把二进制文件拷贝到系统指定目录中


先安装openssl

41,apache安装
./configure --prefix=/usr/local/http2 \
--enable-modules=all \
--enable-mods-shared=all \
--enable-so \
--enable-ssl \
--with-apr=/usr/local/apr \
--with-apr-util=/usr/local/apr-util-httpd \
--enable-rewrite \
--with-ssl=/usr/local/openssl
make && make install

	//安装完毕
	//启动apache
	/usr/local/http2/bin/apachectl start/stop/restart


	//多站点配置：
		// 1，allow from all
		// 2, require all granted

		// <Directory />
		//     AllowOverride none
		//     Require all granted
		//     allow from all
		// </Directory>




查看php编译参数
// /usr/local/php/bin/php -i |grep configure

安装curl

安装mcrypt
// http://www.osyunwei.com/archives/7421.html


42,php安装


// configure配置：
./configure --prefix=/usr/local/php \
--with-apxs2=/usr/local/http2/bin/apxs \
--with-mysql=mysqlnd \
--with-pdo-mysql=mysqlnd \
--with-mysqli=mysqlnd \
--with-freetype-dir=/usr/local/freetype \
--with-gd=/usr/local/libgd \
--with-zlib \
--with-libxml-dir=/usr/local/libxml2 \
--with-png-dir=/usr/local/libpng \
--with-jpeg-dir=/usr/local/jpeg \
--with-xpm-dir=/usr/lib \
--with-curl=/usr/local \
--enable-shared \
--with-mbstring \
--enable-mbstring=all \
--with-config-file-path=/etc \
--enable-inline-optimization \
--disable-debug \
--disable-rpath \
--enable-opcache=no \
--enable-fpm \
--with-fpm-user=www \
--with-fpm-group=www \
--with-iconv \
--with-openssl \
--with-mcrypt \
--enable-sockets 

//或者
./configure \
--with-curl=/usr/local \
--enable-fpm \
--with-gd \
--with-png-dir=/usr/local/libpng \
--with-jpeg-dir=/usr/local/jpeg \
--with-freetype-dir=/usr/local/freetype \
--with-xpm-dir=/usr/lib \
--with-zlib=/usr/local/zlib \
--with-mysqli=/usr/bin/mysql_config



43,数据库mysql安装
//先安装cmake

cmake \
-DCMAKE_INSTALL_PREFIX=/usr/local/mysql \
-DMYSQL_DATADIR=/usr/local/mysql/data \
-DEFAULT_CHARSET=utf8 \
-DEFAULT_COLLATIOM=utf8_general_ci

make && make install

//安装完成
	cp support-files/my-medium.cnf /etc/my.cnf

//配置并初始化
	//创建用户
	useradd mysql
	//分配权限
	chmod +x /usr/local/mysql
	//文件目录归属mysql组员组别
	chown -R mysql.mysql /usr/local/mysql
	//初始化mysql
/usr/local/mysql/scripts/mysql_install_db \
--user=mysql \
--basedir=/usr/local/mysql \
--datadir=/usr/local/mysql/data &

	//把mysql安装文件（除了data）的主人都改为root，避免数据库恢复出厂设置
	chown -R root /usr/local/mysql
	chown -R mysql /usr/local/mysql/data

	//后台运行mysql服务
	/usr/local/mysql/bin/mysqld_safe --user=mysql &

	//查看是否开启mysql服务
	ps -A | grep mysql



44,开启自动启动服务
	
	// 方法一：
		// 1.建立服务文件
		vim /lib/systemd/system/nginx.service
		// 内容：
[Unit]  
Description=nginx  
After=network.target  
   
[Service]  
Type=forking  
ExecStart=/www/lanmps/init.d/nginx start  
ExecReload=/www/lanmps/init.d/nginx restart  
ExecStop=/www/lanmps/init.d/nginx  stop  
PrivateTmp=true  
   
[Install]  
WantedBy=multi-user.target

/**
说明：
[Unit]:服务的说明
Description:描述服务
After:描述服务类别
[Service]服务运行参数的设置
Type=forking是后台运行的形式
ExecStart为服务的具体运行命令
ExecReload为重启命令
ExecStop为停止命令
PrivateTmp=True表示给服务分配独立的临时空间
注意：[Service]的启动、重启、停止命令全部要求使用绝对路径
[Install]服务安装的相关设置，可设置为多用户
*/



#添加到开机启动
systemctl enable mysqld.service


// 2,保存目录：
/lib/systemd/system 

systemctl start nginx.service
// 设置开机自启动
systemctl enable nginx.service
// 停止开机自启动
systemctl disable nginx.service





	//方法二：
	//配置文件路径：
		vi /etc/rc.d/rc.local
		//增加内容：
		/usr/local/http2/bin/apachectl start
		/usr/local/mysql/bin/mysqld_safe --user=mysql &
		service vsftpd start



45,设置开机默认“命令”模式启动
	>systemctl get-default
	//显示当前的模式
	>systemctl set-default multi-user.target

46,系统开机，关机，重启指令：
	>reboot			//重启
	>poweroff		//关机




47,Redis安装
	1) 解压完直接make
	2) 进入src目录，把redis-cli 和 redis-server 拷贝到 /usr/local/redis
	3) 返回上一级，把配置文件Redis.conf 拷贝到 /usr/local/redis
	4) 修改配置文件，后台启动 ----vi redis.conf   修改daemonize yes    //后台启动
	5) 启动 ./redis-server redis.conf
	6) 关闭redis ./redis-cli shutdown


	//配置文件中设置最大内存使用量
          // -----maxmemory 1gb
          // -----maxmemory-policy allkeys-lru

	

	
	// redis的key指令：
		set key value
		get key 						//返回value
		exists key                    	//返回数量，不存在返回0
		del key1 key2 					//删除
		type key 						//获取key的类型
		keys pattern 					//匹配指定模式的所有key
		randomkey 						//返回从当前数据库中随机一个key
		rename oldkeyname newkeyname    //改名字
		dbsize 							//返回当前数据库的key个数
		expire key seconds 				//为key指定过期时间
		ttl key 						//返回当前key剩余过期秒数
		select db-index 				//选择数据库
		move key db-index 				//把当前key从当前数据库移动到指定的数据库
		flushdb  						//删除当前数据库中的所有key
		flushall 						//删除所有数据库中的所有key


	//redis的string类型操作指令：
		//应用场合：记数
		set key value 					//设置key对应的值为string类型的value
		mset key1 value1 key2 value2    //一次性设置多个key的值
		mget key1 key2    				//一次性获取多个key的值
		incr key 						//对key的值做加加(++)操作，并返回新值(计数器),若key不存在，创建该key并赋值为整数1
		decr key 						//对key的值做减减(--)操作，并返回新值(计数器)
		incrby key integer 				//同incr,加指定的数
		decrby key integer 				//同decr,减指定的数
		append key value 				//给指定的key字符串的值追加value
		substr key start end 			//返回截取过的key字符串值
	
	//redis的List类型操作指令：
		//应用场合：最新记录等
		lpush key string 				//在key对应list的头部添加字符串元素
		rpush key string 				//在key对应list的尾部添加字符串元素
		llen key 						//返回key对应的list的长度，key不存在返回0，如果key不是list类型返回错误呀
		lrange key start end 			//返回指定区域内的元素，下标为0
		ltrim key start end 			//截取list,保留指定区域内的元素
		lset key index value 			//设置list指定下标的值
		lrem key count value 			//从key对应的list中删除count个和value相同的元素。count为0时删除全部元素
		lpop key 						//从头部删除元素，并返回删除的元素
		rpop key 						//从尾部删除元素，并返回删除的元素

	//set集合类型指令：
		//应用场合：QQ好友推荐、微博系统的关注好友的使用
		sadd key member 				//添加一个string元素到key对应的set集合中，成功返回1，如果元素已经存在集合中，返回0，key不存在返回错误
		srem key member [member] 		//从key对应的set中移除给定的元素，成功返回1
		smove p1 p2 member 				//从p1对应set中移除member并添加到p2对应的set中
		scard key 						//返回set的元素个数
		sismember key member 			//判断member是否存在key中
		sinter key1 key2 ...keyn 		//返回所有给定的key的交集
		sinterstore p1 key1 ...keyn 	//返回所有给定的key的交集,并把返回值存到p1中
		sunion key1 key2 ...keyn 		//返回所有给定的key的并集
		sunionstore p1 key1 ...keyn 	//返回所有给定的key的并集,并把返回值存到p1中
		sdiff key1 key2 ...keyn 		//返回所有给定的key的差集
		sdiffstore p1 key1 ...keyn 		//返回所有给定的key的差集,并把返回值存到p1中
		smembers key 					//返回key对应set的所有元素，结果是无序的


	//sort set 排序集合类型指令：
		//应用场合：获取最热门（回复量）的5个帖子
		zadd key score(权，用于排序) member 		//添加元素到集合，元素在集合中存在则更次年对应的score
		zrem key member 							//删除指定的元素，1表示成功，元素不存在返回0
		zincrby key incr member 					//按照incr幅度增加对应的member的score值，返回score值
		zrank key member 							//返回指定元素在集合中的排名（下标），集合中的元素按照score的值从小到大排序
		zrevrank key member 						//返回指定元素在集合中的排名（下标），集合中的元素按照score的值从大到小排序
		zrange key start end 						//返回类似lrange操作从集合元素中指定区间元素，返回结果有序
		zrevrange key start end 					//同上，返回score的逆序
		zrangebyscore key min max 					//返回集合中score在给定区间的元素
		zcount key min max 							//返回集合中score在给定区间的数量
		zcard key 									//返回集合中元素的个数
		zscore key element 							//返回给定元素对应的score
		zremrangebyrank key min max 				//删除集合中排名(下标)在给定区间的元素
		zremrangebyscore key min max 				//删除集合中score在给定区间的元素


	//redis的hash类型指令：
		hset key field value 			 		//设置hash field 为指定的值，如果key不存在，则先创建
		hget key field 							//获取指定的hash field
		hmset key field1 value1...fieldn valuen //同时设置hash的多个field
		hmget key field1...fieldn 				//获取全部指定的hash field
		hincrby key field integer 				//将指定的hash field 加上给定的值
		hexists key field 						//测试指定field是否存在
		hdel key field 							//删除指定的hash field
		hlen key 								//返回指定hash的field个数
		hkeys key								//返回hash的所有field
		hvals key 								//返回hash的所有value
		hgetall key 							//返回hash 的所有field和value





48,redis的持久化
	1) 快照持久化:默认开启
	2) 精细持久化(append only file)AOF：需要手动开启

	redis的持久化相关指令
	./redis-cli bgsave 				//手动持久化
	./redis-cli lastsave 			//返回上次保存成功到磁盘的unix时间戳
	./redis-cli shutdown 			//同步保存到服务器并关闭redis服务器
	./redis-cli bgrewriteaof 		//当日志文件过长时优化AOF日志文件存储

	./redis-cli -h 127.0.0.1 -p 6379 bgsave 		//手动发起快照



49,redis的主从设置
	//主库：只做写操作（增删改）
	//从库：只做查询操作
	从库配置文件配置：
		1) slaveof  主库ip  组库端口
		2) 禁止从库对主库的写操作：slave-read-only yes





50,phpredis的安装
	>tar zxvf phpredis.tar.gz
	>cd phpredis
	>/usr/local/php/bin/phpize  		//用phpize生成configure配置文件
	//此时如果缺少autoconfig支持，先安装autoconfig
		// (autoconfig又对m4有依赖，继续安装m4,./configure && make && make install)
	>./configure --with-php-config=/usr/local/php/bin/php-config  		//配置
	>make && make install
	2、配置php支持
	>vi /usr/local/php/etc/php.ini  									#编辑配置文件，在最后一行添加以下内容
	添加
	extension="redis.so"
	>:wq! 																#保存退出

	//重启apache



	// php中使用：
		// 1) 获取redis对象
			$redis = new Redis();
		// 2) 连接到服务器
			$redis->connect("127.0.0.1","6379");
		// 3) 使用指令
			$redis->set("flower","rose");




51,nginx安装
前提：安装openssl,mod-ssl
./configure \
--prefix=/usr/local/nginx \
--with-http_stub_status_module \
--with-http_ssl_module  \
--with-http_realip_module

配置：
	/**
	user www www;
	#user  nobody;
	worker_processes  1;

	error_log  /usr/local/nginx/logs/error.log;
	#error_log  logs/error.log;
	#error_log  logs/error.log  notice;
	#error_log  logs/error.log  info;

	#pid        logs/nginx.pid;


	events {
	    worker_connections  1024;
	}


	http {
	    include       mime.types;
	    default_type  application/octet-stream;

	    #log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
	    #                  '$status $body_bytes_sent "$http_referer" '
	    #                  '"$http_user_agent" "$http_x_forwarded_for"';

	    #access_log  logs/access.log  main;

	    sendfile        on;
	    #tcp_nopush     on;

	    #keepalive_timeout  0;
	    keepalive_timeout  65;

	    #gzip  on;

	    server {
	        listen       80;
	        server_name  localhost;

	        #charset koi8-r;

	        access_log  /usr/local/nginx/logs/host.access.log;
	        #access_log  logs/host.access.log  main;

	        location / {
	            root   /var/www/www.xgguo.cn;
	            index  index.html index.htm index.php;
	        }

	        #error_page  404              /404.html;

	        # redirect server error pages to the static page /50x.html
	        #
	        error_page   500 502 503 504  /50x.html;
	        location = /50x.html {
	            root   html;
	        }

	        # proxy the PHP scripts to Apache listening on 127.0.0.1:80
	        #
	        #location ~ \.php$ {
	        #    proxy_pass   http://127.0.0.1;
	        #}

	        # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
	        #
	        location ~ \.php$ {
	            root           html;
	            fastcgi_pass   127.0.0.1:9000;
	            fastcgi_index  index.php;
	            fastcgi_param  SCRIPT_FILENAME  /var/www/www.xgguo.cn$fastcgi_script_name;
	            include        fastcgi_params;
	        }

	        # deny access to .htaccess files, if Apache's document root
	        # concurs with nginx's one
	        #
	        #location ~ /\.ht {
	        #    deny  all;
	        #}
	    }


	    # another virtual host using mix of IP-, name-, and port-based configuration
	    #
	    #server {
	    #    listen       8000;
	    #    listen       somename:8080;
	    #    server_name  somename  alias  another.alias;

	    #    location / {
	    #        root   html;
	    #        index  index.html index.htm;
	    #    }
	    #}


	    # HTTPS server
	    #
	    #server {
	    #    listen       443 ssl;
	    #    server_name  localhost;

	    #    ssl_certificate      cert.pem;
	    #    ssl_certificate_key  cert.key;

	    #    ssl_session_cache    shared:SSL:1m;
	    #    ssl_session_timeout  5m;

	    #    ssl_ciphers  HIGH:!aNULL:!MD5;
	    #    ssl_prefer_server_ciphers  on;

	    #    location / {
	    #        root   html;
	    #        index  index.html index.htm;
	    #    }
	    #}


	    server {
	        listen       443;
	        server_name  test.xgguo.cn;
	        ssl on;
	        root /var/www/test.xgguo.cn;
	        index index.html index.htm;

	        ssl_certificate      /usr/local/nginx/conf/ssl/ssl.pem;
	        ssl_certificate_key  /usr/local/nginx/conf/ssl/ssl.key;

	        ssl_session_cache    shared:SSL:1m;
	        ssl_session_timeout  5m;

	        ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
	        ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
	        ssl_prefer_server_ciphers on;

	        location / {
	            root   /var/www/test.xgguo.cn;
	            index  index.html index.htm;
	        }
	    }

	}

	**/


52:配置https
	安装php时，添加--enable-fpm \
	配置php-fpm来支持nginx

	
