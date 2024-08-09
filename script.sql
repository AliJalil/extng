create table cities
(
    lId    int(250) auto_increment
        primary key,
    lName  varchar(250)         not null,
    isActive  tinyint(1) default 1 null,
    isDeleted tinyint(1) default 0 null
);

create table departments
(
    depId     int auto_increment
        primary key,
    depName   varchar(100) charset utf8 null,
    isDeleted tinyint default 0         null,
    isActive  tinyint default 1         null
)
    collate = utf8_unicode_ci;

create table faculties
(
    fId       int(250) auto_increment
        primary key,
    fName     varchar(250)                           not null,
    depId     int                                    not null,
    phoneNo   varchar(255)                           null,
    isActive  varchar(1) default '1'                 null,
    isDeleted tinyint    default 0                   null,
    createdBy int                                    null,
    createdAt datetime   default current_timestamp() null,
    constraint centerName
        unique (fName, phoneNo, isActive, isDeleted, createdBy, createdAt),
    constraint centerName_2
        unique (fName, phoneNo)
)
    collate = utf8_unicode_ci;

create table manage
(
    id       int auto_increment
        primary key,
    showYear varchar(4) null
);

create table permssions
(
    id           int auto_increment
        primary key,
    user_id      int(255)   not null,
    addUser      tinyint(1) not null,
    deleteUser   tinyint(1) not null,
    editUser     tinyint(1) not null,
    deleteVolu   tinyint(1) not null,
    addVolu      tinyint(1) not null,
    editVolu     tinyint(1) not null,
    addCenter    tinyint(1) not null,
    deleteCenter tinyint(1) not null,
    editCenter   tinyint(1) not null
)
    collate = utf8_unicode_ci;

create table subjects
(
    sId       int auto_increment
        primary key,
    sName     varchar(250)                          null,
    fId       int                                   null,
    isActive  tinyint   default 1                   null,
    isDeleted tinyint   default 0                   null,
    createdBy int                                   null,
    createdAt timestamp default current_timestamp() null
);

create table tablestb
(
    tId       int auto_increment
        primary key,
    fId       int                                    null comment 'معرف الكلية',
    sId       int                                    not null comment ' معرف المادة',
    sType     int                                    not null comment 'نوع الدراسة',
    lId       int                                    not null comment 'معرف المرحلة',
    pType     int                                    not null comment 'نوع الحصة
',
    dId       int                                    not null comment 'معرف اليوم',
    fromTime  varchar(255)                           not null comment 'وقت البدأ',
    toTime    varchar(255)                           not null comment 'الى الساعة',
    link      varchar(250)                           null,
    isDeleted tinyint(1) default 0                   null,
    userId    int        default 0                   null,
    createdAt timestamp  default current_timestamp() null,
    notes     varchar(255)                           not null
)
    collate = utf8_unicode_ci;

create table users
(
    userId          int auto_increment
        primary key,
    name            varchar(255)                           null,
    userName        varchar(255)                           null,
    password        varchar(255)                           null,
    centerId        int                                    null,
    phoneNo         varchar(255)                           null,
    city            varchar(255)                           null,
    img             varchar(255)                           null,
    age             varchar(255)                           null,
    identifierName  varchar(255)                           null,
    identifierPhone varchar(255)                           null,
    isActive        tinyint(1) default 1                   null,
    addedBy         int                                    null,
    createdAt       datetime   default current_timestamp() null,
    isDeleted       tinyint(1) default 0                   null,
    uImgDeleted     tinyint(1) default 0                   null
);


