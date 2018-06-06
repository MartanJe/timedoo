-- password = 'abcd'

INSERT INTO user (username, password, name, surname, email) VALUES ('user1',  '$2y$10$Re6SSHFjyr25eaddRBQHP.tvQ0nUr0EqUK05y12bGhgM.MzeHa5c6', 'Boris', 'Mastný', 'Boris.Mastny@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user2',  '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Lýdie', 'Kupcová', 'Lydie.Kupcova@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user3',  '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Marika', 'Němečková', 'Marika.Nemeckova@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user4',  '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Květoslava', 'Koudelová', 'Kvetoslava.Koudelova@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user5',  '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Vítězslav', 'Hála', 'Vitezslav.Hala@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user6',  '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Jitka', 'Rusová', 'Jitka.Rusova@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user7',  '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Jindřich', 'Maňák', 'Jindrich.Manak@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user8',  '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Bohdana', 'Mazalová', 'Bohdana.Mazalova@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user9',  '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Lukáš', 'Šimíček', 'Lukas.simicek@seznam.cz');
INSERT INTO user (username, password, name, surname, email) VALUES ('user10', '$2y$10$Hp2LVygvPjukidKmLHR7SeAWZHIf.54iVGLydsJfMsDsyql1BDliy', 'Robert', 'Borkovec', 'Robert.Borkovec@seznam.cz');


INSERT INTO project (project_name, active ) VALUES ('Stavba domu', '1');
INSERT INTO project (project_name, active ) VALUES ('Sazeni stromu', '1');
INSERT INTO project (project_name, active ) VALUES ('Shaneni drog', '1');
INSERT INTO project (project_name, active ) VALUES ('Párty na suchu', '1');
INSERT INTO project (project_name, active ) VALUES ('Napsat neco jako Toggl', '1');


INSERT INTO role (description) VALUES ('admin');
INSERT INTO role (description) VALUES ('user');
INSERT INTO role (description) VALUES ('manager');



-- CONTRIBUTIONS AND TASKS

--   contributes of project 1 (Stavba domu)
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('1', '1', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('2', '1', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('3', '1', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('4', '1', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('5', '1', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('6', '1', '2');
--   tasks of project 1 (Stavba domu)
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Koupit si doutnik', '1',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Nakoupit cement', '1',  '1', '3');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Nakoupit cihly', '1',  '1', '3');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Obstarat 10 lopat', '1',  '1', '3');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Vykopat zalkady', '1',  '2', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Postavit zdi', '1',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Udelat strechu', '1',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Nastukovat zdi + fasada', '1',  '6', '6');


INSERT INTO activity (active, id_user, id_task, date_activity_start, date_activity_end) VALUES  ('0', '1', '1', '2017-08-23 12:15:06', '2017-08-23 16:15:06' );
INSERT INTO activity (active, id_user, id_task, date_activity_start, date_activity_end) VALUES  ('0', '1', '1', '2017-08-23 16:15:06', '2017-08-23 22:15:06' );
INSERT INTO activity (active, id_user, id_task, date_activity_start) VALUES  ('1', '1', '1', '2017-08-24 16:15:06' );

INSERT INTO activity (active, id_user, id_task, date_activity_start, date_activity_end) VALUES  ('0', '3', '2', '2017-08-23 16:15:06', '2017-08-23 22:15:01' );

--   contributes of project 2 (Stazeni stromu)
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('9', '2', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('10', '2', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('1', '2', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('4', '2', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('7', '2', '2');
--   tasks of project 2 (Stazeni stromu)
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Koupit strom',           '2',  '9', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Koupit krumpac',         '2',  '9', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Pujcit lopatu',          '2',  '9', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Sehnat konev s vodou',   '2',  '9', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Vykopat diru',           '2',  '9', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Posadit strom do diry',  '2',  '9', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Zahrnout koreny hlinou', '2',  '10', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Zalit vodou z konve',    '2',  '10', '7');



--   contributes of project 3 (Shaneni drog)
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('1',  '3', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('2',  '3', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('3',  '3', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('4',  '3', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('5',  '3', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('6',  '3', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('7',  '3', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('8',  '3', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('9',  '3', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('10', '3', '1');
--   tasks of project 3 (Shaneni drog)
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Zeptat se v trafice',       '3',  '7', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Zkusit to v Tescu',         '3',  '7', '2');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Od zevlu v parku',          '3',  '7', '3');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('V policejnim trezoru',      '3',  '7', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Vypestovat doma travu',     '3',  '7', '5');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Od vetnamcu',               '3',  '7', '5');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Od negru v ulicce',         '3',  '7', '5');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Od marokancu',              '3',  '7', '5');



--   contributes of project 4 (Party na suchu)
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('1', '4', '1');
--   tasks of project 4 (Party na suchu)
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Pozadat babicku o penize',                 '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Pozadat mamu o dzus',                      '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Koupit v samosce mliko',                   '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Ukrast bombony',                           '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Koupit Rychle spunty',                     '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Sehnat CD s Dadou Patrasovou',             '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Pit dzus poslouchat Dadu',                 '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Stocit se do klubicka',                    '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Plakat ze nemas zadny kamose',             '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Ze si jen troska co do noci programuje',   '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Prestat plakat',                           '4',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Utrit si slzy a jit zas programovat',      '4',  '1', '1');



--   contributes of project 5 (Napsat neco jako Toggl)
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('1',  '5', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('10', '5', '1');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('4',  '5', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('7',  '5', '2');
INSERT INTO contribute (id_user, id_project, id_role) VALUES ('5',  '5', '1');
--   tasks of project 5 (Napsat neco jako Toggl)
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Sehnat 30kc',                             '5',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Poslat 30kc programatorum v indii',       '5',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Radsi si to udelat sam',                  '5',  '1', '1');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Vytvorit databazi',                       '5',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Naprogramovat modely',                    '5',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Naprogramovat presentery',                '5',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Nakonfigurovat router',                   '5',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Stahnout kus templatu z netu',            '5',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Upravit template k obrazu svemu',         '5',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Rozdelit do @layout.latte',               '5',  '4', '4');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Hejtovat baletku',                        '5',  '7', '7');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Zoufat',                                  '5',  '7', '7');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Nak to doplacat dokonce',                 '5',  '1', '7');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Odevzdat Dominikovi',                     '5',  '1', '7');
INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES ('Dostat job',                              '5',  '1', '10');



-- invitations (requests)
INSERT INTO invite (id_user_from, id_user_to, id_project) VALUES ('10', '3', '1');



