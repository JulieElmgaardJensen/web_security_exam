SELECT user_username FROM users WHERE user_username = :user_username

UPDATE users
SET user_name = :user_name,
user_last_name = :user_last_name,
user_address = :user_address,
user_updated_at = :time
WHERE user_id = :user_id

UPDATE users SET user_is_blocked = !user_is_blocked WHERE user_id = :user_id

INSERT INTO  users 
                                    (user_id, 
                                    user_name, 
                                    user_last_name, 
                                    user_username, 
                                    user_address, 
                                    user_email, 
                                    user_password, 
                                    user_role, 
                                    user_created_at, 
                                    user_updated_at, 
                                    user_deleted_at, 
                                    user_is_blocked)
        VALUES 
        (:user_id, 
        :user_name, 
        :user_last_name,
        :user_username,
        :user_address,
        :user_email, 
        :user_password, 
        :user_role,
        :user_created_at, 
        :user_updated_at, 
        :user_deleted_at, 
        :user_is_blocked


SELECT user_name, user_last_name, user_id FROM users
                        WHERE user_name LIKE :user_name 
                        OR user_last_name LIKE :user_last_name
                        OR user_id LIKE :user_id

SELECT *
                        FROM orders AS o
                        JOIN users AS u ON o.order_delivered_by_fk = u.user_id
                        JOIN products AS p ON o.order_product_fk = p.product_id
                        WHERE (o.order_id LIKE :order_id
                            OR u.user_name LIKE :user_name
                            OR u.user_last_name LIKE :user_last_name
                            OR p.product_name LIKE :product_name)
                            AND u.user_id = :user_id


SELECT *
                        FROM orders AS o
                        JOIN users AS u ON o.order_user_fk = u.user_id
                        JOIN products AS p ON o.order_product_fk = p.product_id
                        WHERE (o.order_id LIKE :order_id
                            OR u.user_name LIKE :user_name
                            OR u.user_last_name LIKE :user_last_name
                            OR p.product_name LIKE :product_name)
                            AND u.user_id = :user_id


SELECT *
                        FROM orders AS o
                        JOIN users AS u ON o.order_user_fk = u.user_id
                        JOIN products AS p ON o.order_product_fk = p.product_id
                        WHERE o.order_id LIKE :order_id
                            OR u.user_name LIKE :user_name
                            OR u.user_last_name LIKE :user_last_name
                            OR p.product_name LIKE :product_name


SELECT * FROM users WHERE user_email = :user_email

SELECT user_email FROM users WHERE user_email = :user_email

SELECT * FROM users LIMIT :page, 2

SELECT * FROM orders LIMIT :page, 2

DELETE FROM users WHERE user_id = :user_id

UPDATE users SET user_deleted_at = :time WHERE user_id = :user_id

DELETE FROM orders WHERE order_id = :order_id