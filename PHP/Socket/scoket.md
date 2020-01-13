# socket

- socket 是一种操作系统提供的进程间 `通信机制`
- 操作系统对于网络协议的实现模式是，二到四层的处理代码在内核里，七层的处理代码让应用自己去做，而两者需要 `跨内核态和用户态` 通信，就需要 `系统调用完成衔接`，这就是 socket

## 套接字接口（socket API）

操作系统中，通常会为应用程序提供一组接口，称为套接字接口（socket API）

## 套接字地址（socket address）

在套接字接口中，以 `IP` 地址及 `端口` 组成套接字地址（socket address）

## 套接字对（socket pairs）

远程的套接字地址（ip:port） + 本地套接字地址（ip:port） + 协议（protocol） = 五元组（five-element tuple）= 套接字对（socket pairs）


