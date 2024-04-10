INSERT INTO users (username, password, name, email, phone)
VALUES 
  ('john_doe', 'password123', 'John Doe', 'john@example.com', 1234567890),
  ('jane_smith', 'securepass', 'Jane Smith', 'jane@example.com', 9876543210),
  ('alice_wonder', 'mypassword', 'Alice Wonder', 'alice@example.com', 5551234567),
  ('bob_green', 'letmein', 'Bob Green', 'bob@example.com', 4447890123),
  ('sarah_jones', 'p@ssw0rd', 'Sarah Jones', 'sarah@example.com', 9998887777),
  ('mike_andrews', 'password321', 'Mike Andrews', 'mike@example.com', 1112223333),
  ('emily_brown', 'brownie', 'Emily Brown', 'emily@example.com', 7776665555),
  ('alex_king', 'king123', 'Alex King', 'alex@example.com', 2223334444),
  ('sam_carter', 'sammy123', 'Sam Carter', 'sam@example.com', 6667778888),
  ('lisa_adams', 'lisalisa', 'Lisa Adams', 'lisa@example.com', 3334445555);

INSERT INTO items (name, price, category, condition, size, brand, model, date, description, user, imagePath)
VALUES 
  ('Guitar', 299.99, 'Musical Instruments', 'Used', 'Medium', 'Fender', 'Stratocaster', '2024-04-10', 'Classic electric guitar.', 'john_doe', '../images/flowe.png'),
  ('Laptop', 899.99, 'Electronics', 'New', 'Large', 'Apple', 'MacBook Pro', '2024-04-10', 'High-performance laptop.', 'jane_smith', '../images/flowe.png'),
  ('Camera', 499.50, 'Electronics', 'Refurbished', 'Small', 'Canon', 'EOS Rebel T7i', '2024-04-10', 'Great DSLR camera for beginners.', 'alice_wonder', '../images/flowe.png'),
  ('Watch', 199.99, 'Accessories', 'Used', 'One Size', 'Rolex', 'Submariner', '2024-04-10', 'Luxury watch with timeless design.', 'bob_green', '../images/flowe.png'),
  ('Bicycle', 399.00, 'Sports', 'New', 'Large', 'Giant', 'Talon 29', '2024-04-10', 'Mountain bike for all terrains.', 'sarah_jones', '../images/flowe.png'),
  ('Smartphone', 599.99, 'Electronics', 'New', 'Medium', 'Samsung', 'Galaxy S20', '2024-04-10', 'Latest smartphone with advanced features.', 'mike_andrews', '../images/flowe.png'),
  ('Television', 799.99, 'Electronics', 'New', 'Large', 'Sony', 'Bravia X900H', '2024-04-10', '4K HDR smart TV for immersive viewing.', 'emily_brown', '../images/flowe.png'),
  ('Desk', 149.50, 'Furniture', 'Used', 'Medium', 'IKEA', 'LINNMON', '2024-04-10', 'Simple desk for home office.', 'alex_king', '../images/flowe.png'),
  ('Headphones', 99.99, 'Electronics', 'New', 'One Size', 'Sony', 'WH-1000XM4', '2024-04-10', 'Noise-cancelling wireless headphones.', 'sam_carter', '../images/flowe.png'),
  ('Backpack', 49.99, 'Accessories', 'New', 'One Size', 'North Face', 'Jester', '2024-04-10', 'Durable backpack for everyday use.', 'lisa_adams', '../images/flowe.png');

INSERT INTO comments (mainuser, userc, date, text, rating)
VALUES 
  ('john_doe', 'jane_smith', '2024-04-10', 'Great guitar!', 5),
  ('jane_smith', 'john_doe', '2024-04-10', 'Excellent laptop.', 4),
  ('alice_wonder', 'bob_green', '2024-04-10', 'Nice camera!', 4),
  ('bob_green', 'sarah_jones', '2024-04-10', 'Awesome watch.', 5),
  ('sarah_jones', 'mike_andrews', '2024-04-10', 'Love this bike!', 5),
  ('mike_andrews', 'emily_brown', '2024-04-10', 'Fantastic phone.', 4),
  ('emily_brown', 'alex_king', '2024-04-10', 'Impressive TV.', 4),
  ('alex_king', 'sam_carter', '2024-04-10', 'Good desk.', 3),
  ('sam_carter', 'lisa_adams', '2024-04-10', 'Great headphones!', 5),
  ('lisa_adams', 'john_doe', '2024-04-10', 'Nice backpack.', 4);

INSERT INTO favorites (user, item)
VALUES 
  ('john_doe', 'Guitar'),
  ('jane_smith', 'Laptop'),
  ('alice_wonder', 'Camera'),
  ('bob_green', 'Watch'),
  ('sarah_jones', 'Bicycle'),
  ('mike_andrews', 'Smartphone'),
  ('emily_brown', 'Television'),
  ('alex_king', 'Desk'),
  ('sam_carter', 'Headphones'),
  ('lisa_adams', 'Backpack');
