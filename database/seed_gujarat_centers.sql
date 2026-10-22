-- =====================================================================
-- EarthCycle Gujarat Composting Facilities — Master Seed Dataset
-- 12 Municipal Plants & Community Drop-off Hubs
-- =====================================================================

USE `composting_db`;

INSERT INTO `centers` (`id`,`name`,`type`,`city`,`address`,`latitude`,`longitude`,`phone`,`operating_hours`,`accepted_waste`,`capacity`,`services`,`status`) VALUES
(1,'AMC Central Bio-Composting Plant','Municipal Composting Facility','Ahmedabad','Pirana Solid Waste Treatment Complex, Near Behrampura, Ahmedabad, Gujarat 380022',22.9818400,72.5833200,'+91 79 2539 1811','Mon - Sat: 08:00 AM - 05:00 PM','Vegetable mandi waste, kitchen wet waste, horticulture branches','300 TPD','Municipal Hub','Active'),
(2,'Sabarmati Eco Community Compost Yard','Community Composting Center','Ahmedabad','Near Riverfront Park East, Subhash Bridge Approach, Sabarmati, Ahmedabad, Gujarat 380027',23.0722100,72.5855400,'+91 79 2755 0412','Mon - Sun: 07:00 AM - 07:00 PM','Household kitchen scraps, dry leaves, coconut coir, compost bin overflow','15 TPD','Free Culture Dist.','Active'),
(3,'Vastrapur Urban Bio-Resource Hub','Organic Waste Drop-off','Ahmedabad','Opposite Vastrapur Lake Garden Gate 2, Vastrapur, Ahmedabad, Gujarat 380015',23.0360200,72.5298500,'+91 98250 14820','Tue - Sun: 08:00 AM - 06:00 PM','Fruit peels, vegetable scraps, shredded garden leaves','8 TPD','Urban Yard','Active'),
(4,'SMC Bhestan Integrated Waste Processing Plant','Municipal Composting Facility','Surat','Bhestan Solid Waste Processing Zone, Dindoli-Bhestan Canal Road, Surat, Gujarat 395023',21.1352400,72.8273600,'+91 261 242 3751','Mon - Sat: 08:30 AM - 05:30 PM','Segregated wet municipal waste, wholesale grain & mandi organic waste','250 TPD','Municipal Hub','Active'),
(5,'Adajan Community Green Composting Station','Community Composting Center','Surat','Anand Mahal Road, Near Community Hall, Adajan, Surat, Gujarat 395009',21.1969200,72.7933100,'+91 261 278 9910','Mon - Sun: 07:30 AM - 06:30 PM','Residential kitchen waste, garden grass cuttings, dry leaf litter','12 TPD','Residential Hub','Active'),
(6,'Vadodara Municipal Atladara Bio-Processing Site','Municipal Composting Facility','Vadodara','Atladara Waste Processing Complex, Padra Road, Vadodara, Gujarat 390012',22.2708300,73.1558200,'+91 265 243 3116','Mon - Sat: 09:00 AM - 05:00 PM','Bulk wet organic waste, market vegetable remains, tree pruning debris','200 TPD','Municipal Hub','Active'),
(7,'Sayaji Baug Botanical Composting Yard','Community Composting Center','Vadodara','Sayaji Baug Garden Campus, Dak Bungalow Road, Vadodara, Gujarat 390001',22.3129500,73.1894200,'+91 265 279 5522','Daily: 07:00 AM - 06:00 PM','Dry leaves, temple flowers, pruned park branches, fruit peels','10 TPD','Botanical Hub','Active'),
(8,'Rajkot Municipal Corporation Aji Bio-Compost Yard','Municipal Composting Facility','Rajkot','Near Aji Dam Industrial Zone, Bhavnagar Highway, Rajkot, Gujarat 360003',22.2612000,70.8197400,'+91 281 222 1730','Mon - Sat: 08:30 AM - 05:00 PM','City wet waste, vegetable market surplus, agricultural trimmings','180 TPD','Municipal Hub','Active'),
(9,'Race Course Community Eco-Compost Project','Community Composting Center','Rajkot','Race Course Ring Road, Near Children Traffic Park, Rajkot, Gujarat 360001',22.2982100,70.7937300,'+91 281 245 8820','Mon - Sun: 07:00 AM - 07:00 PM','Domestic kitchen greens, lawn trimmings, coffee grounds and tea leaves','6 TPD','Park Center','Active'),
(10,'Gandhinagar Green Capital Sector 28 Facility','Municipal Composting Facility','Gandhinagar','Sector 28 GIDC Waste Management Zone, Gandhinagar, Gujarat 382028',23.2599100,72.6569200,'+91 79 2322 0440','Mon - Sat: 09:00 AM - 05:00 PM','Institutional cafeteria scraps, government garden leaves, green trimmings','120 TPD','Capital Eco Hub','Active'),
(11,'Nari Road Bio-Compost Treatment Facility','Municipal Composting Facility','Bhavnagar','Nari Road Solid Waste Yard, Near Ring Road, Bhavnagar, Gujarat 364004',21.7850200,72.1380100,'+91 278 242 4811','Mon - Sat: 09:00 AM - 05:00 PM','Segregated residential food waste, vegetable cutting waste','90 TPD','Municipal Hub','Active'),
(12,'Navsari Krishi Vigyan Composting Center','Community Composting Center','Navsari','Navsari Agricultural University Campus, Eru Char Rasta, Navsari, Gujarat 396450',20.9274500,72.9056200,'+91 2637 282 771','Mon - Sat: 09:00 AM - 05:00 PM','Farm crop residues, cow dung slurry, household food scraps','25 TPD','Agri University','Active')
ON DUPLICATE KEY UPDATE 
  `name`=VALUES(`name`),
  `type`=VALUES(`type`),
  `city`=VALUES(`city`),
  `address`=VALUES(`address`),
  `latitude`=VALUES(`latitude`),
  `longitude`=VALUES(`longitude`),
  `phone`=VALUES(`phone`),
  `operating_hours`=VALUES(`operating_hours`),
  `accepted_waste`=VALUES(`accepted_waste`),
  `capacity`=VALUES(`capacity`),
  `services`=VALUES(`services`),
  `status`=VALUES(`status`);
