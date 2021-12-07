
CREATE TABLE IF NOT EXISTS Points(
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    point_change int,
    reason varchar(20),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id)
)