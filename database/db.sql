use pro;

drop table if exists experimenters;

create table experimenters(
  id		integer auto_increment primary key,
  login 	varchar(100) null,
  password 	varchar(40) null
) ENGINE=InnoDB;

drop table if exists sessions;
create table sessions(
  id  integer auto_increment primary key,
  size integer not null,
  first_task_deadline datetime not null,
  second_task_deadline datetime not null,
  third_task_deadline datetime not null,
  subject_deadline_enabled boolean default false,
  time_limit time not null,
  penalty double not null,
  payoff integer not null
) Engine=InnoDB;

drop table if exists subject_task_schedules;
create table subject_task_schedules(
  id  integer auto_increment primary key,
  subject_id integer not null,
  task integer not null, # Task IDs {1, 2, 3}
  deadline datetime not null
) Engine=InnoDB;


drop table if exists subjects;
create table subjects(
  id integer auto_increment primary key,
  session_id	integer not null,
  login	varchar(100) not null,
  password varchar(255) not null,
  email varchar(100) default null,
  # unregistered = 1, email registered = 2, first completed = 3, deadline set = 4, reminder payment completed = 5
  # second questionnaire set = 6, survey completed = 7
  status integer not null
) ENGINE=InnoDB;

drop table if exists task_logs;
create table task_logs(
  id					integer auto_increment primary key,
  subject_id		integer not null,
  task_id				integer not null,
  # Event: Issued = 1, Failure = 2, Display Task = 3, Complete Task = 4,
  event integer not null,
  date_time       datetime not null
) ENGINE=InnoDB;

drop table if exists survey_answers;
create table survey_answers(
    id integer auto_increment primary key,
    subject_id integer not null,
    type integer not null,
    question integer not null,
    answer varchar(255) not null
) ENGINE=InnoDB;

