<!-- @format -->

# 도커를 이용한 LAMP 개발환경 구축

## 1. 소개 및 특징

-   docker-compose라는 단 하나의 명령어로 한번에 Apache, MySQL, PHP, phpMyAdmin, Redis 개발환경을 구축
-   정상 작동하는지 확인하기 위해 PHP를 처음 공부할 때 작성해보았던 CRUD 연습코드를 넣어 봄

> 학습자료
>
> -   [LAMP stack built with Docker Compose][1]
> -   [생활코딩][2]

[1]: https://github.com/sprintcube/docker-compose-lamp
[2]: https://www.youtube.com/c/%EC%83%9D%ED%99%9C%EC%BD%94%EB%94%A91

<br/>

## 2. 사용기술

-   Docker
-   PHP
    <br/>

## 3. 학습후기

1. docker-compose를 이해하기 위해 생활코딩을 통해 Docker의 기초부터 학습함
2. PHP 학습 초기에 개발환경을 구축하기 위해 몇 시간에 걸쳐 개별 프로그램들을 깔고 삽질하며 설정했던걸 명령어 하나로 손쉽고 빠르게 해결할 수 있었음
3. host명을 localhost가 아닌 설정된 서비스명인 database를 사용해야 DB에 접속됨
   <br/><br/>

![image](https://user-images.githubusercontent.com/79514508/144739142-a881e13b-4290-473e-a27d-57e7c9be7bd7.png)
