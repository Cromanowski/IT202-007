ALTER TABLE Competitions ADD COLUMN expires TIMESTAMP DEFAULT (DATE_ADD(CURRENT_TIMESTAMP, INTERVAL duration DAY))
