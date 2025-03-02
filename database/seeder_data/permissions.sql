
INSERT INTO `permissions` ( `name`, `guard_name`, `created_at`, `updated_at`) VALUES
('role list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('role add', 'web', '2024-06-24 22:39:20', '2024-06-25 22:43:01'),
('role edit', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:50'),
('role view', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:38'),
('role status', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:02'),
('role delete', 'web', '2024-06-24 22:39:20', '2024-06-25 22:41:33'),

('permission list', 'web', '2024-06-25 22:50:02', '2024-06-25 22:50:02'),
('permission add', 'web', '2024-06-25 22:50:17', '2024-06-25 22:50:17'),
('permission edit', 'web', '2024-06-25 22:50:28', '2024-06-25 22:50:50'),
('permission view', 'web', '2024-06-25 22:51:02', '2024-06-25 22:51:02'),
('permission status', 'web', '2024-06-25 22:51:14', '2024-06-25 22:51:14'),
('permission delete', 'web', '2024-06-25 22:51:39', '2024-06-25 22:51:39'),

('audit list', 'web', '2024-06-25 22:51:39', '2024-06-25 22:51:39'),

('setting system-setting', 'web', '2024-06-27 06:40:25', '2024-07-23 07:36:25'),
('setting general-setting', 'web', '2024-07-23 07:36:30', '2024-07-23 07:36:30'),
('setting branding-setting', 'web', '2024-07-23 07:37:12', '2024-07-23 07:37:12'),

('customer list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('customer view', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:38'),
('customer status', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:02'),
('customer delete', 'web', '2024-06-24 22:39:20', '2024-06-25 22:41:33'),

('admin list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('admin add', 'web', '2024-06-24 22:39:20', '2024-06-25 22:43:01'),
('admin edit', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:50'),
('admin view', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:38'),
('admin status', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:02'),
('admin delete', 'web', '2024-06-24 22:39:20', '2024-06-25 22:41:33'),

('port list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('port add', 'web', '2024-06-24 22:39:20', '2024-06-25 22:43:01'),
('port edit', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:50'),
('port status', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:02'),
('port delete', 'web', '2024-06-24 22:39:20', '2024-06-25 22:41:33'),

('container list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('container add', 'web', '2024-06-24 22:39:20', '2024-06-25 22:43:01'),
('container edit', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:50'),
('container status', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:02'),
('container delete', 'web', '2024-06-24 22:39:20', '2024-06-25 22:41:33'),

('order-charge list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('order-charge add', 'web', '2024-06-24 22:39:20', '2024-06-25 22:43:01'),
('order-charge edit', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:50'),
('order-charge status', 'web', '2024-06-24 22:39:20', '2024-06-25 22:42:02'),
('order-charge delete', 'web', '2024-06-24 22:39:20', '2024-06-25 22:41:33'),

('pending-order list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
-- ('pending-order own-list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('pending-order view', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),

('accept-order list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
-- ('accept-order own-list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('accept-order view', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),

('reject-order list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
-- ('reject-order own-list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('reject-order view', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),

('shipped-order list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
-- ('shipped-order own-list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('shipped-order view', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),

('delivery-order list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
-- ('delivery-order own-list', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21'),
('delivery-order view', 'web', '2024-06-24 22:11:22', '2024-06-25 22:49:21')

;
