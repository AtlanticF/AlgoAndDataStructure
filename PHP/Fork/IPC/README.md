# PHP 进程间通信

- 共享内存
- 信号量
- socket
- 队列
- 管道

## 共享内存
多进程之间共用某一块内存进行通信

- ftok ( string $pathname , string $proj ) : int 将指定的 pathname 和 proj 转换成整数，用于创建共享内存

### shm 扩展

- shm_attach ( int $key [, int $memsize [, int $perm = 0666 ]] ) : resource 创建一块共享内存空间
- shm_detach ( resource $shm_identifier ) : bool 断开共享内存的链接 (任然存在)
- shm_remove ( resource $shm_identifier ) : bool 删除共享内存，所有的数据将会被清除
- shm_put_var ( resource $shm_identifier , int $variable_key , mixed $variable ) : bool 插入或更新共享内存中给定的 key 的 value 值, key 只支持 int 类型
- shm_get_var ( resource $shm_identifier , int $variable_key ) : mixed 返回共享内存中指定 key 的值
- shm_remove_var ( resource $shm_identifier , int $variable_key ) : bool 移除给定 key 在共享内存中的值并释放空间

### shmop 扩展

- shmop_open ( int $key , string $flags , int $mode , int $size ) : resource 创建一个共享内存块，指定模式，权限和大小
- shmop_close ( resource $shmid ) : void 断开和共享内存的链接 (任然存在)
- shmop_delete ( resource $shmid ) : bool 删除共享内存块
- shmop_read ( resource $shmid , int $start , int $count ) : string 读取共享内存块中指定字节数的数据
- shmop_size ( resource $shmid ) : int 返回当前内存块已占用的字节数
- shmop_write ( resource $shmid , string $data , int $offset ) : int 从指定字节数开始写入数据

### 信号量

- sem_get ( int $key [, int $max_acquire = 1 [, int $perm = 0666 [, int $auto_release = 1 ]]] ) : resource 获取一个信号量 id
- sem_acquire ( resource $sem_identifier [, bool $nowait = FALSE ] ) : bool 尝试对信号量做 P 操作 -1，如果失败则挂起
- sem_release ( resource $sem_identifier ) : bool 对信号量做 V 操作，释放信号量 +1
- sem_remove ( resource $sem_identifier ) : bool 移除信号量

## Socket

