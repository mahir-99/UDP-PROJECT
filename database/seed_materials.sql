-- =====================================================================
-- EarthCycle Organic Composting Materials — Seed Dataset
-- 18 Inputs: Greens (Nitrogen), Browns (Carbon), Prohibited Items
-- =====================================================================

USE `composting_db`;

INSERT INTO `materials` (`id`, `name`, `type`, `cn_ratio`, `decomposition_speed`, `description`, `pro_tip`) VALUES
(1, 'Fruit & Vegetable Peels', 'Green', '15:1 – 20:1', 'Fast (1-2 wks)', 'Kitchen scraps, gourd rinds, tomato skins, coriander stems.', 'Chop large rinds into 1-inch squares for 3x faster microbial digestion.'),
(2, 'Used Tea Leaves & Coffee Grounds', 'Green', '20:1', 'Fast (1-2 wks)', 'Chai patti residue and brewed ground coffee rich in available nitrogen.', 'Rinse milky tea grounds thoroughly with water before adding to compost.'),
(3, 'Fresh Lawn Trimmings & Garden Greens', 'Green', '18:1 – 22:1', 'Fast (3-5 days)', 'Lawn mower grass clippings and green weed shoots before seed formation.', 'Spread thin; thick wet grass clumps compact and turn anaerobic in 48 hours.'),
(4, 'Crushed Eggshells', 'Green', 'Mineral Buffer', 'Slow (6-8 wks)', 'Calcium carbonate mineral buffer from domestic kitchens.', 'Pound into fine powder using mortar and pestle to neutralize organic acidity.'),
(5, 'Stale Bread & Roti Crusts', 'Green', '25:1', 'Moderate (2 wks)', 'Leftover dry whole wheat chapatis, rotis, and preservative-free bread crusts.', 'Tear into small flakes and bury at the center of the pile away from flies.'),
(6, 'Overripe Pulses & Soaked Dal Residue', 'Green', '12:1', 'Fast (4-7 days)', 'Protein-rich legume rinsings, sprout discards, boiled dal residue.', 'Use in small quantities; high nitrogen requires immediate 3x brown cover.'),
(7, 'Dry Fallen Neem & Peepal Leaves', 'Brown', '40:1 – 60:1', 'Moderate (3-5 wks)', 'Crisp dry leaves gathered from Gujarat municipal sidewalks and garden terraces.', 'Crush by hand before layering; neem acts as a natural biological insect repellent.'),
(8, 'Shredded Corrugated Cardboard', 'Brown', '350:1', 'Moderate (4-6 wks)', 'Unprinted delivery cardboard, egg cartons, and brown grocery paper bags.', 'Soak in bucket for 5 minutes then shred into strips for ideal air pocket pockets.'),
(9, 'Coconut Coir & Husk Dust', 'Brown', '100:1', 'Moderate (4 wks)', 'Coir fibers and pith from fresh coconut water vendors across Gujarat.', 'Excellent moisture accumulator; maintains 50% humidity during 44°C summer.'),
(10, 'Clean Untreated Wood Sawdust', 'Brown', '400:1', 'Slow (8-12 wks)', 'Fine shavings from untreated carpenter wood (no varnish or laminates).', 'Sprinkle lightly; dense wood dust compacts into water-repellent layers if clotted.'),
(11, 'Dry Sugarcane Bagasse', 'Brown', '150:1', 'Moderate (4-6 wks)', 'Pressed cane stalks from roadside juice vendors, fibrous and porous.', 'Cut into 3-inch pieces; provides unmatched aeration structural integrity.'),
(12, 'Wood Ashes from Firewood Chulhas', 'Brown', '25:1 (Alkaline)', 'Instant dissolve', 'Cold wood ash rich in potassium and potash nutrients.', 'Use sparsely (max 1 cup per 20L compost) to avoid spiking pH above 8.5.'),
(13, 'Dairy, Paneer & Cheese Residues', 'Prohibited', 'Harmful', 'Putrefies', 'Milk cream, ghee remnants, curd runoff, and processed cheese cubes.', 'Rancid butterfats coat organic matter, block oxygen, and attract rodents.'),
(14, 'Cooked Meat, Fish & Bones', 'Prohibited', 'Severe Vector', 'Putrefies', 'Animal bones, chicken skin, fish viscera, and tallow gravy.', 'Causes virulent putrefactive odors, maggot infestations, and health risks.'),
(15, 'Pet Waste (Dog & Cat Feces)', 'Prohibited', 'Bio-Hazard', 'Pathogenic', 'Animal excrement containing Toxoplasma gondii parasites and pathogens.', 'Dangerous pathogens survive typical backyard temperatures; never put in garden compost.'),
(16, 'Plastic, Foils & Glossy Prints', 'Prohibited', 'Non-biodegradable', 'Permanent', 'Synthetic courier envelopes, plastic laminates, and shiny magazines.', 'Microplastics poison living soil food webs and release toxic chemical plasticizers.'),
(17, 'Diseased Plants & Blight Vines', 'Prohibited', 'Spore Carrier', 'Infectious', 'Tomato plants infected with fungal blight, powdery mildew, or viral leaf curl.', 'Fungal spores survive in compost and will reinfect subsequent crop seasons.'),
(18, 'Chemically Treated or Painted Wood', 'Prohibited', 'Toxic Chemicals', 'Leaches Toxins', 'Plywood scraps, pressure-treated lumber with copper/arsenic, oil painted wood.', 'Heavy metals and chemical binders kill aerobic bacteria and worms.')
ON DUPLICATE KEY UPDATE
  `type`=VALUES(`type`),
  `cn_ratio`=VALUES(`cn_ratio`),
  `decomposition_speed`=VALUES(`decomposition_speed`),
  `description`=VALUES(`description`),
  `pro_tip`=VALUES(`pro_tip`);
