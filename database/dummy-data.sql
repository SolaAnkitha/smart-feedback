-- ✅ DO NOT delete OTP-verified users (is_verified = 1 AND company_id IS NOT NULL)
DELETE FROM feedbacks;

-- ✅ Insert 15 dummy users (password: 'password')
INSERT IGNORE INTO users (id, name, email, password, role, is_verified)
VALUES
(1, 'Mrs. Ashlee Franklin DDS', 'user1@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(2, 'Thomas Sherman', 'user2@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(3, 'Cynthia Gonzalez', 'user3@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(4, 'Carol Smith', 'user4@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(5, 'Cynthia Mccoy', 'user5@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(6, 'Anna Hart', 'user6@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(7, 'Debra Kim', 'user7@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(8, 'Joseph Cox', 'user8@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(9, 'Catherine Mendoza', 'user9@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(10, 'Sherri Perez', 'user10@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(11, 'Brittany Morse', 'user11@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(12, 'Belinda Henry', 'user12@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(13, 'Matthew Cordova', 'user13@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(14, 'Daniel Brown', 'user14@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1),
(15, 'Carl Rivera', 'user15@example.com', '$2y$10$ZbYlD.WG2EaT.HkyHOx3D.n.2EpF8lVnUv/7Irk3v2yBaJ8koDOh6', 'user', 1);

-- ✅ Optional: Add admin if not present
INSERT IGNORE INTO users (id, name, email, password, role, is_verified)
VALUES (99, 'Admin', 'admin@example.com', '$2y$10$ESYcT3jI7kpHWTBBXJSBsuG2eM8jUTPElxnSDwRBrXYHhCmygHULC', 'admin', 1);

-- ✅ Insert 30 feedbacks with timestamps
INSERT INTO feedbacks (user_id, category, rating, comment, sentiment, created_at) VALUES
(1, 'Website', 5, 'Excellent UI and UX.', 'positive', CURRENT_TIMESTAMP - INTERVAL 1 HOUR),
(2, 'Support', 4, 'Support was quick and helpful.', 'positive', CURRENT_TIMESTAMP - INTERVAL 2 HOUR),
(3, 'Service', 2, 'Service was delayed.', 'negative', CURRENT_TIMESTAMP - INTERVAL 3 HOUR),
(4, 'Mobile App', 3, 'App works but lags sometimes.', 'neutral', CURRENT_TIMESTAMP - INTERVAL 4 HOUR),
(5, 'Performance', 1, 'Very slow experience.', 'negative', CURRENT_TIMESTAMP - INTERVAL 5 HOUR),
(6, 'Support', 5, 'Resolved my issue quickly.', 'positive', CURRENT_TIMESTAMP - INTERVAL 6 HOUR),
(7, 'Website', 3, 'Okay but could improve.', 'neutral', CURRENT_TIMESTAMP - INTERVAL 7 HOUR),
(8, 'Service', 4, 'Quite satisfied.', 'positive', CURRENT_TIMESTAMP - INTERVAL 8 HOUR),
(9, 'Website', 2, 'Pages load slowly.', 'negative', CURRENT_TIMESTAMP - INTERVAL 9 HOUR),
(10, 'Mobile App', 4, 'Loved the new update!', 'positive', CURRENT_TIMESTAMP - INTERVAL 10 HOUR),
(11, 'Performance', 3, 'Average load times.', 'neutral', CURRENT_TIMESTAMP - INTERVAL 11 HOUR),
(12, 'Support', 4, 'Decent support.', 'positive', CURRENT_TIMESTAMP - INTERVAL 12 HOUR),
(13, 'Website', 1, 'Crashes often.', 'negative', CURRENT_TIMESTAMP - INTERVAL 13 HOUR),
(14, 'Service', 5, 'Very friendly staff.', 'positive', CURRENT_TIMESTAMP - INTERVAL 14 HOUR),
(15, 'Support', 2, 'Did not help.', 'negative', CURRENT_TIMESTAMP - INTERVAL 15 HOUR),
(1, 'Mobile App', 5, 'Fast and responsive.', 'positive', CURRENT_TIMESTAMP - INTERVAL 16 HOUR),
(2, 'Performance', 4, 'Improved performance.', 'positive', CURRENT_TIMESTAMP - INTERVAL 17 HOUR),
(3, 'Service', 3, 'Mediocre service.', 'neutral', CURRENT_TIMESTAMP - INTERVAL 18 HOUR),
(4, 'Support', 1, 'Terrible experience.', 'negative', CURRENT_TIMESTAMP - INTERVAL 19 HOUR),
(5, 'Website', 5, 'Beautiful layout.', 'positive', CURRENT_TIMESTAMP - INTERVAL 20 HOUR),
(6, 'Service', 4, 'Prompt delivery.', 'positive', CURRENT_TIMESTAMP - INTERVAL 21 HOUR),
(7, 'Support', 3, 'Support needs improvement.', 'neutral', CURRENT_TIMESTAMP - INTERVAL 22 HOUR),
(8, 'Performance', 1, 'Very laggy.', 'negative', CURRENT_TIMESTAMP - INTERVAL 23 HOUR),
(9, 'Website', 5, 'Fast and clean UI.', 'positive', CURRENT_TIMESTAMP - INTERVAL 24 HOUR),
(10, 'Mobile App', 4, 'Smooth animations.', 'positive', CURRENT_TIMESTAMP - INTERVAL 25 HOUR),
(11, 'Support', 2, 'No response.', 'negative', CURRENT_TIMESTAMP - INTERVAL 26 HOUR),
(12, 'Service', 3, 'Neutral experience.', 'neutral', CURRENT_TIMESTAMP - INTERVAL 27 HOUR),
(13, 'Website', 5, 'Superb design.', 'positive', CURRENT_TIMESTAMP - INTERVAL 28 HOUR),
(14, 'Mobile App', 2, 'Crashes on load.', 'negative', CURRENT_TIMESTAMP - INTERVAL 29 HOUR),
(15, 'Performance', 4, 'Very responsive now.', 'positive', CURRENT_TIMESTAMP - INTERVAL 30 HOUR);
