-- Insert default categories
INSERT INTO kategori (name, post_count) VALUES
('Machine Learning', 0),
('Cloud Computing', 0),
('Mobile Development', 0),
('Security', 0),
('Data Science', 0),
('Web Development', 0),
('DevOps', 0),
('IoT', 0),
('Blockchain', 0),
('UI/UX Design', 0)
ON CONFLICT (name) DO NOTHING;
