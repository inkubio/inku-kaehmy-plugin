-- run with from cmd
-- mysql -u wordpressuser -p wordpress < populate-db.sql

-- Tags

INSERT INTO inku_kaehmy_tag (tag_name_fi)
VALUES ('Tapahtumien järjestäminen');

INSERT INTO inku_kaehmy_tag (tag_name_fi)
VALUES ('Kopomouhot');

INSERT INTO inku_kaehmy_tag (tag_name_fi)
VALUES ('Kädenvääntö korkeakoulun kanssa');

INSERT INTO inku_kaehmy_tag (tag_name_fi)
VALUES ('Killan helvettiin saattaminen');

INSERT INTO inku_kaehmy_tag (tag_name_fi)
VALUES ('Fuksien kuksiminen');

INSERT INTO inku_kaehmy_tag (tag_name_fi)
VALUES ('Kiltahuoneen sotkeminen');

INSERT INTO inku_kaehmy_tag (tag_name_fi)
VALUES ('Fuksien pilaaminen');

INSERT INTO inku_kaehmy_tag (tag_name_fi)
VALUES ('Siltojen polttaminen');


-- Grabbings

INSERT INTO inku_kaehmy_grabbing (userID, is_hallitus, grabbing_text, grabbing_title, grabbing_batch)
VALUES (100,1,'Me is good at cooking (read: drinking) so i want to be the hostess','My liver has had an easy life thus far.','Syksy 2018');

INSERT INTO inku_kaehmy_grabbing (userID, is_hallitus, grabbing_text, grabbing_title, time_stamp, grabbing_batch)
VALUES (99,1,'As the treasurer I will steal all of our money','My student allowances ran out', '18-10-23 11:59:09', 'Syksy 2018');

INSERT INTO inku_kaehmy_grabbing (userID, is_hallitus, grabbing_text, grabbing_title, time_stamp, grabbing_batch)
VALUES (23,1,'As the chairperson I will beat every board member with a chair until they cry.', 'Violence solves everything','18-10-22 05:02:04', 'Syksy 2018');

INSERT INTO inku_kaehmy_grabbing (userID, is_hallitus, grabbing_text, grabbing_title, time_stamp, grabbing_batch)
VALUES (102,0,'I really don''t like to do anything therefore I fit to this position perfectly', 'Songbookofficial','18-09-22 11:59:22', 'Syksy 2018');

INSERT INTO inku_kaehmy_grabbing (userID, is_hallitus, grabbing_text, grabbing_title, time_stamp, grabbing_batch)
VALUES (103,1,'I have gotten very annoyed about kiltiksen namutilanne recently', 'I want to be the next Musculus Gluteus Maximus','18-10-10 06:31:44', 'Syksy 2018');

INSERT INTO inku_kaehmy_is_tagged
VALUES (1,1);

INSERT INTO inku_kaehmy_is_tagged
VALUES (1,7);

INSERT INTO inku_kaehmy_is_tagged
VALUES (1,4);

INSERT INTO inku_kaehmy_is_tagged
VALUES (2,4);

INSERT INTO inku_kaehmy_is_tagged
VALUES (2,8);

INSERT INTO inku_kaehmy_is_tagged
VALUES (3,7);

INSERT INTO inku_kaehmy_is_tagged
VALUES (3,8);

INSERT INTO inku_kaehmy_is_tagged
VALUES (3,4);

INSERT INTO inku_kaehmy_is_tagged
VALUES (4,6);

INSERT INTO inku_kaehmy_is_tagged
VALUES (5,7);

-- comments

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (103,'What is your go to hangover cure??','18-10-11 11:31:44', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (104,'What do you do when the treasurer steals all our money?','18-11-12 04:31:44', 3);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (103,'What is one thing you would like to improve in your life?','18-10-10 06:34:42', 2);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (107,'What is love?','18-9-10 06:41:44', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (100,'How does google work?','18-12-10 09:31:44', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (105,'Can google see my future?','18-09-10 11:31:44', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (107,'What is the best role in the board?','18-10-06 06:44:44', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (112,'What is your favorite asian board game?','18-11-10 09:16:44', 1);


INSERT INTO inku_kaehmy_has_comment (comment_ID, parent_grabbing_ID)
VALUES (1,1);

INSERT INTO inku_kaehmy_has_comment (comment_ID, parent_grabbing_ID)
VALUES (2,3);

INSERT INTO inku_kaehmy_has_comment (comment_ID, parent_grabbing_ID)
VALUES (3,4);

INSERT INTO inku_kaehmy_has_comment (comment_ID, parent_grabbing_ID)
VALUES (4,2);

INSERT INTO inku_kaehmy_has_comment (comment_ID, parent_grabbing_ID)
VALUES (5,4);

INSERT INTO inku_kaehmy_has_comment (comment_ID, parent_grabbing_ID, parent_comment_ID)
VALUES (6,4,5);

INSERT INTO inku_kaehmy_has_comment (comment_ID, parent_grabbing_ID)
VALUES (7,5);

INSERT INTO inku_kaehmy_has_comment (comment_ID, parent_grabbing_ID, parent_comment_ID)
VALUES (8,5,7);
