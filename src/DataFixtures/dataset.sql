START TRANSACTION;

INSERT INTO `user` (`id`, `nickname`, `password`, `profile_picture`, `mail`) VALUES
(1, 'FirstUser', '$2y$10$HHvD8nUwUIygwVRuWAasNe0bsWA57LAosJQZQmwgPFoaGBzRvsBUW', 'https://randomuser.me/api/portraits/lego/8.jpg', 'admin@snowtricks.com');

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'grabs'),
(2, 'rotations'),
(3, 'flips'),
(4, 'rotations désaxées'),
(5, 'slides'),
(6, 'one foot tricks'),
(7, 'old school');

INSERT INTO `trick` (`id`, `name`, `slug`, `description`, `category_id`, `creator_id`, `creation_date`, `cover_image`) VALUES
(1, 'mute', 'mute', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'mute-5ecb706736112.jpeg'),
(2, 'sad ou melancholie ou style week', 'sad-ou-melancholie-ou-style-week', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'sad-5ecb7160aa177.jpeg'),
(3, 'indy', 'indy', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'indy-5ecb71b59cb12.jpeg'),
(4, 'stalefish', 'stalefish', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'stalefish-5ecb7223c7d24.jpeg'),
(5, 'tail grab', 'tail-grab', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'tailgrab-5ecb72696a931.jpeg'),
(6, 'nose grab', 'nose-grab', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'nosegrab-5ecb7290408b5.jpeg'),
(7, 'japan / japan air', 'japan-japan-air', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'japanair-5ecb72b747b32.jpeg'),
(8, 'seat belt', 'seat-belt', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'seatbelt-5ecb72f10463e.jpeg'),
(9, 'truck driver', 'truck-driver', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 1, 1, NOW(), 'truckdriver-5ecb7335c4e1a.jpeg'),
(10, '180', '180', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut turpis ligula, elementum sed massa a, fringilla maximus ex. Cras tempus mi quis nisl convallis, sit amet ultricies nulla tincidunt. Maecenas ut ante accumsan, dictum arcu in, vulputate tortor. Etiam porta lorem risus, eu luctus nisl tincidunt ac. Praesent et molestie tortor. Aenean ipsum sapien, aliquet nec vehicula at, condimentum quis justo. Vestibulum vel aliquam orci, feugiat aliquet eros. Pellentesque lacinia tempor accumsan.\r\n\r\nPellentesque congue lacinia nunc. Fusce volutpat, elit eu varius dictum, tortor purus tempus tortor, et pretium ipsum diam non erat. Nulla at dolor quis urna iaculis tempus non vitae urna. Pellentesque non viverra libero. Ut ac auctor risus, nec hendrerit justo. Vestibulum risus ante, lobortis eu erat at, convallis maximus dui. Etiam ultricies eget leo nec viverra. Nulla iaculis posuere nulla sit amet pretium. Nunc eget purus dui. Integer laoreet tellus elit. Nullam at mi ipsum. Fusce a ante nec tortor porta faucibus. Sed ut scelerisque risus. Aliquam a eros rutrum, facilisis est vitae, sodales orci.', 2, 1, NOW(), '180-5ecb73590b297.jpeg');

COMMIT;