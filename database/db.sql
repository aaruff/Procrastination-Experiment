use pro;

#--
# Users
#--
drop table if exists users;
create table users(
  id		integer auto_increment primary key,
  login 	varchar(100) null,
  password 	varchar(255) null,
  role integer not null # 1 => Subject, 2 => Experimenter
) Engine=InnoDB;

#--
# Subjects
#--
drop table if exists subjects;
create table subjects(
  user_id		integer primary key,
  session_id integer not null,
  state integer default 0 # A subject only plays one game so placing state here will suffice
) ENGINE=InnoDB;

#--
# Treatments: A treatment can consist of varying parameters.
#--
drop table if exists treatments;
create table treatments(
  id		integer auto_increment primary key,
  type integer not null,
  session_id integer not null
) ENGINE=InnoDB;

#--
# Sessions: A session can is created.
#--
drop table if exists sessions;
create table sessions(
  id integer AUTO_INCREMENT primary key,
  size integer not null
) Engine=InnoDB;

#--
# Tasks: A treatment will assign one or more tasks to each subject.
#--
drop table if exists tasks;
create table tasks(
  id		integer auto_increment primary key,
  number integer not null,
  treatment_id integer not null,
  primary_deadline datetime not null,
  secondary_deadline datetime default null,
  secondary_deadline_enabled boolean default false,
  time_limit integer default 0,
  payoff double not null,
  penalty_rate double default 0.0,
  penalty_rate_enabled boolean default false
) Engine=InnoDB;

#--
# Task Log: Stores task submission events
#
# Event Types -- Issued = 1, Failure = 2, Display Task = 3, Complete Task = 4,
#--
drop table if exists task_submission_logs;
create table task_submission_logs(
  id	integer auto_increment primary key,
  task_id	integer not null,
  event integer not null,
  date_time datetime not null
) ENGINE=InnoDB;

#----------------------------------------
# Incoming Survey Tables
#----------------------------------------
drop table if exists incoming_survey;
create table incoming_survey(
) ENGINE InnoDB;

drop table if exists incoming_survey;
create table incoming_survey(
  id					integer auto_increment primary key,
  user_id integer not null,
  major varchar(255) not null,
  gpa double not null,
  number_courses integer not null,
  number_clubs integer not null,
  hours_course_work integer not null,
  num_major_assignments integer not null,
  num_minor_assignments integer not null,
  num_exams integer not null,
  employed boolean not null,
  hours_work integer default 0,
  hours_social_obligations integer default 0,
  hours_family_obligations integer default 0,
  rank_conscientiousness integer not null,
  rank_assignment_lateness integer not null,
  rank_tardiness integer not null,
  rank_external_distractions integer not null,
  rank_dependability integer not null,
  rank_ability_follow_schedule integer not null,
  rank_ability_organize integer not null,
  rank_ability_pay_attention integer not null,
  certificates_year integer not null,
  temptation integer not null,
  temptation_certificates_year integer not null,
  nights_per_year integer not null
) ENGINE InnoDB;


#----------------------------------------
# Survey Date Time Intervals
#----------------------------------------
drop table if exists survey_datetime_intervals;
create table survey_datetime_intervals(
  id integer auto_increment primary key,
  survey_id integer not null,
  type varchar(255) not null,
  start_datetime datetime not null,
  end_datetime datetime
) ENGINE=InnoDB;
