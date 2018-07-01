INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (103,'What is your go to hangover cure??','18-10-11 11:31:44 PM', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (104,'What do you do when the treasurer steals all our money?','18-11-12 04:31:44 PM', 3);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (103,'What is one thing you would like to improve in your life?','18-10-10 06:34:42 AM', 2);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (107,'What is love?','18-9-10 06:41:44 PM', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (100,'How does google work?','18-12-10 09:31:44 PM', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (105,'Can google see my future?','18-09-10 11:31:44 PM', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (107,'What is the best role in the board?','18-10-06 06:44:44 PM', 1);

INSERT INTO inku_kaehmy_comment (userID, comment_text, time_stamp, depth)
VALUES (112,'What is your favorite asian board game?','18-11-10 09:16:44 PM', 1);


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