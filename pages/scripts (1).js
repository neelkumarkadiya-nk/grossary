const products = {
  fruits: [
    {
      id: 1,
      name: "Apple",
      price: 60,
      unit: "1 kg",
      image:
        "https://images.unsplash.com/photo-1619546813926-a78fa6372cd2?w=500",
      category: "fruits",
      details: {
        description:
          "Crisp, juicy apples handpicked from the finest orchards. Perfect for snacking, baking, or adding to salads.",
        origin: "Himachal Pradesh, India",
        weight: "1 kg (approx. 6-8 apples)",
        shelf_life: "7-10 days",
        nutrition: {
          calories: "52 kcal",
          carbs: "14g",
          fiber: "2.4g",
          sugar: "10g",
          protein: "0.3g",
        },
        tags: ["Fresh", "Organic", "High Fiber"],
      },
    },
    {
      id: 2,
      name: "Banana",
      price: 50,
      unit: "1 dozen",
      image:
        "https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=500",
      category: "fruits",
      details: {
        description:
          "Sweet, energy-packed bananas perfect for breakfast, smoothies, or a quick on-the-go snack.",
        origin: "Kerala, India",
        weight: "1 dozen (approx. 1.2 kg)",
        shelf_life: "4-6 days",
        nutrition: {
          calories: "89 kcal",
          carbs: "23g",
          fiber: "2.6g",
          sugar: "12g",
          protein: "1.1g",
        },
        tags: ["Energy Boost", "Potassium Rich", "Vegan"],
      },
    },
    {
      id: 3,
      name: "Orange",
      price: 70,
      unit: "1 kg",
      image:
        "https://images.unsplash.com/photo-1580052614034-c55d20bfee3b?w=500",
      category: "fruits",
      soldOut: true,
      details: {
        description:
          "Tangy and vitamin-C rich oranges. Great for juicing, eating fresh, or zesting into desserts.",
        origin: "Nagpur, Maharashtra",
        weight: "1 kg (approx. 5-6 oranges)",
        shelf_life: "10-14 days",
        nutrition: {
          calories: "47 kcal",
          carbs: "12g",
          fiber: "2.4g",
          sugar: "9g",
          protein: "0.9g",
        },
        tags: ["Vitamin C", "Immunity Booster", "Juicy"],
      },
    },
    {
      id: 4,
      name: "Mango",
      price: 90,
      unit: "500 g",
      image: "https://images.unsplash.com/photo-1553279768-865429fa0078?w=500",
      category: "fruits",
      details: {
        description:
          "King of fruits - sweet, aromatic Alphonso mangoes with a smooth, fiberless pulp.",
        origin: "Ratnagiri, Maharashtra",
        weight: "500 g (approx. 2-3 mangoes)",
        shelf_life: "3-5 days",
        nutrition: {
          calories: "60 kcal",
          carbs: "15g",
          fiber: "1.6g",
          sugar: "13.7g",
          protein: "0.8g",
        },
        tags: ["Premium", "Seasonal", "Alphonso"],
      },
    },
    {
      id: 11,
      name: "Strawberry",
      price: 50,
      unit: "250 g",
      image:
        "https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=500",
      category: "fruits",
      details: {
        description:
          "Plump, red strawberries bursting with sweetness. Perfect for desserts, smoothies, or fresh eating.",
        origin: "Mahabaleshwar, Maharashtra",
        weight: "250 g punnet",
        shelf_life: "2-3 days",
        nutrition: {
          calories: "32 kcal",
          carbs: "7.7g",
          fiber: "2g",
          sugar: "4.9g",
          protein: "0.7g",
        },
        tags: ["Antioxidant Rich", "Low Calorie", "Fresh"],
      },
    },
    {
      id: 14,
      name: "Watermelon",
      price: 80,
      unit: "1 piece (~3 kg)",
      image:
        "https://images.unsplash.com/photo-1589984662646-e7b2e4962f18?w=500",
      category: "fruits",
      soldOut: true,
      details: {
        description:
          "Refreshing and hydrating watermelons. 92% water content makes them the ultimate summer fruit.",
        origin: "Rajasthan, India",
        weight: "Approx. 3 kg per piece",
        shelf_life: "5-7 days (whole)",
        nutrition: {
          calories: "30 kcal",
          carbs: "7.6g",
          fiber: "0.4g",
          sugar: "6.2g",
          protein: "0.6g",
        },
        tags: ["Hydrating", "Summer Special", "Seedless"],
      },
    },
    {
      id: 25,
      name: "Blueberries",
      price: 30,
      unit: "200 g",
      image:
        "https://images.unsplash.com/photo-1498557850523-fd3d118b962e?w=500",
      category: "fruits",
      details: {
        description:
          "Tiny powerhouses of antioxidants. Ideal for cereals, yogurt, baking, or snacking straight from the pack.",
        origin: "Imported (USA / Chile)",
        weight: "200 g punnet",
        shelf_life: "5-7 days",
        nutrition: {
          calories: "57 kcal",
          carbs: "14.5g",
          fiber: "2.4g",
          sugar: "10g",
          protein: "0.7g",
        },
        tags: ["Superfood", "Antioxidant", "Brain Health"],
      },
    },
    {
      id: 34,
      name: "Grapes",
      price: 65,
      unit: "500 g",
      image:
        "https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=500",
      category: "fruits",
      details: {
        description:
          "Plump, seedless green grapes bursting with natural sweetness. Great for snacking, fruit salads, or freezing as a cool summer treat.",
        origin: "Nashik, Maharashtra",
        weight: "500 g bunch",
        shelf_life: "5-7 days (refrigerated)",
        nutrition: {
          calories: "69 kcal",
          carbs: "18g",
          fiber: "0.9g",
          sugar: "15g",
          protein: "0.7g",
        },
        tags: ["Seedless", "Sweet", "Antioxidant Rich"],
      },
    },
    {
      id: 35,
      name: "Papaya",
      price: 45,
      unit: "1 piece (~700 g)",
      image:
        "https://images.unsplash.com/photo-1526318472351-c75fcf070305?w=500",
      category: "fruits",
      details: {
        description:
          "Ripe, golden papaya with silky flesh and a honey-sweet flavour. Excellent for digestion, smoothies, or a tropical fruit bowl.",
        origin: "Coimbatore, Tamil Nadu",
        weight: "Approx. 700 g per piece",
        shelf_life: "3-5 days",
        nutrition: {
          calories: "43 kcal",
          carbs: "11g",
          fiber: "1.7g",
          sugar: "7.8g",
          protein: "0.5g",
        },
        tags: ["Digestive Aid", "Vitamin C", "Tropical"],
      },
    },
    {
      id: 36,
      name: "Pomegranate",
      price: 85,
      unit: "1 piece (~400 g)",
      image:
        "https://images.unsplash.com/photo-1541344999736-83eca272f6fc?w=500",
      category: "fruits",
      details: {
        description:
          "Ruby-red pomegranate arils packed with antioxidants and a refreshing sweet-tart flavour. Add to salads, juices, or eat straight from the fruit.",
        origin: "Solapur, Maharashtra",
        weight: "Approx. 400 g per piece",
        shelf_life: "7-10 days",
        nutrition: {
          calories: "83 kcal",
          carbs: "18.7g",
          fiber: "4g",
          sugar: "13.7g",
          protein: "1.7g",
        },
        tags: ["Antioxidant", "Heart Health", "Immunity Booster"],
      },
    },
  ],
  vegetables: [
    {
      id: 5,
      name: "Carrot",
      price: 60,
      unit: "500 g",
      image:
        "https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=500",
      category: "vegetables",
      details: {
        description:
          "Crunchy, naturally sweet carrots. Great raw as a snack, in salads, curries, halwa, or juiced.",
        origin: "Punjab, India",
        weight: "500 g (approx. 4-6 carrots)",
        shelf_life: "7-10 days",
        nutrition: {
          calories: "41 kcal",
          carbs: "10g",
          fiber: "2.8g",
          sugar: "4.7g",
          protein: "0.9g",
        },
        tags: ["Beta-Carotene", "Eye Health", "Crunchy"],
      },
    },
    {
      id: 6,
      name: "Broccoli",
      price: 20,
      unit: "1 head (~400 g)",
      image:
        "https://images.unsplash.com/photo-1584270354949-c26b0d5b4a0c?w=500",
      category: "vegetables",
      soldOut: true,
      details: {
        description:
          "Fresh broccoli florets, dense with vitamins and minerals. Steam, stir-fry, or eat raw in salads.",
        origin: "Ooty, Tamil Nadu",
        weight: "1 head (approx. 400 g)",
        shelf_life: "3-5 days",
        nutrition: {
          calories: "34 kcal",
          carbs: "7g",
          fiber: "2.6g",
          sugar: "1.7g",
          protein: "2.8g",
        },
        tags: ["Protein Rich", "Iron", "Vitamin K"],
      },
    },
    {
      id: 7,
      name: "Tomato",
      price: 50,
      unit: "500 g",
      image:
        "https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=500",
      category: "vegetables",
      details: {
        description:
          "Farm-fresh tomatoes, ripe and flavourful. Essential for gravies, salads, sandwiches, and chutneys.",
        origin: "Nashik, Maharashtra",
        weight: "500 g (approx. 5-6 tomatoes)",
        shelf_life: "5-7 days",
        nutrition: {
          calories: "18 kcal",
          carbs: "3.9g",
          fiber: "1.2g",
          sugar: "2.6g",
          protein: "0.9g",
        },
        tags: ["Lycopene", "Heart Health", "Low Calorie"],
      },
    },
    {
      id: 15,
      name: "Spinach",
      price: 40,
      unit: "250 g bunch",
      image:
        "https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=500",
      category: "vegetables",
      details: {
        description:
          "Tender baby spinach leaves, rich in iron and folate. Use in salads, smoothies, dals, or sauteed as a side.",
        origin: "Pune, Maharashtra",
        weight: "250 g bunch",
        shelf_life: "3-4 days",
        nutrition: {
          calories: "23 kcal",
          carbs: "3.6g",
          fiber: "2.2g",
          sugar: "0.4g",
          protein: "2.9g",
        },
        tags: ["Iron Rich", "Folate", "Green Superfood"],
      },
    },
    {
      id: 16,
      name: "Potato",
      price: 30,
      unit: "1 kg",
      image:
        "https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=500",
      category: "vegetables",
      details: {
        description:
          "Versatile, starchy potatoes perfect for curries, fries, boiling, baking, or making chaat.",
        origin: "Agra, Uttar Pradesh",
        weight: "1 kg (approx. 6-8 medium potatoes)",
        shelf_life: "2-3 weeks (cool and dry)",
        nutrition: {
          calories: "77 kcal",
          carbs: "17g",
          fiber: "2.2g",
          sugar: "0.8g",
          protein: "2g",
        },
        tags: ["Energy", "Versatile", "Budget Friendly"],
      },
    },
    {
      id: 18,
      name: "Cucumber",
      price: 20,
      unit: "2 pieces",
      image:
        "https://images.unsplash.com/photo-1449300079323-02e209d9d3a6?w=500",
      category: "vegetables",
      details: {
        description:
          "Cool and crisp cucumbers. Slice into salads, raita, sandwiches, or enjoy with a pinch of salt.",
        origin: "Karnataka, India",
        weight: "2 medium cucumbers (approx. 400 g)",
        shelf_life: "5-7 days",
        nutrition: {
          calories: "15 kcal",
          carbs: "3.6g",
          fiber: "0.5g",
          sugar: "1.7g",
          protein: "0.7g",
        },
        tags: ["Hydrating", "Low Calorie", "Cooling"],
      },
    },
    {
      id: 28,
      name: "Corn",
      price: 25,
      unit: "2 cobs",
      image: "https://images.unsplash.com/photo-1551754655-cd27e38d2076?w=500",
      category: "vegetables",
      details: {
        description:
          "Sweet golden corn cobs, great for boiling, grilling, or making bhutta with lemon and chilli.",
        origin: "Gujarat, India",
        weight: "2 cobs (approx. 500 g)",
        shelf_life: "3-5 days",
        nutrition: {
          calories: "86 kcal",
          carbs: "19g",
          fiber: "2g",
          sugar: "6.3g",
          protein: "3.2g",
        },
        tags: ["Sweet", "Fibre Rich", "Grillable"],
      },
    },
    {
      id: 37,
      name: "Onion",
      price: 30,
      unit: "1 kg",
      image:
        "https://images.unsplash.com/photo-1508747703725-719777637510?w=500",
      category: "vegetables",
      details: {
        description:
          "Pungent, flavour-packed red onions - the base of every Indian dish. Use raw in salads and sandwiches or cook down into rich gravies and biryanis.",
        origin: "Nasik, Maharashtra",
        weight: "1 kg (approx. 6-8 medium onions)",
        shelf_life: "2-3 weeks (cool and dry)",
        nutrition: {
          calories: "40 kcal",
          carbs: "9.3g",
          fiber: "1.7g",
          sugar: "4.2g",
          protein: "1.1g",
        },
        tags: ["Kitchen Staple", "Flavour Base", "Budget Friendly"],
      },
    },
    {
      id: 38,
      name: "Cauliflower",
      price: 35,
      unit: "1 head (~600 g)",
      image:
        "https://images.unsplash.com/photo-1568584711075-3d021a7c3ca3?w=500",
      category: "vegetables",
      details: {
        description:
          "Dense, white cauliflower florets with a mild, nutty taste. Perfect for aloo gobi, cauliflower rice, pakoras, or roasting with spices.",
        origin: "Ooty, Tamil Nadu",
        weight: "1 head (approx. 600 g)",
        shelf_life: "5-7 days (refrigerated)",
        nutrition: {
          calories: "25 kcal",
          carbs: "5g",
          fiber: "2g",
          sugar: "1.9g",
          protein: "1.9g",
        },
        tags: ["Low Carb", "Vitamin C", "Versatile"],
      },
    },
    {
      id: 39,
      name: "Capsicum",
      price: 40,
      unit: "3 pieces",
      image: "https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?w=500",
      category: "vegetables",
      details: {
        description:
          "Crisp, vibrant mixed capsicums (red, yellow, green). Adds colour and crunch to stir-fries, pasta, pizzas, and paneer dishes.",
        origin: "Himachal Pradesh, India",
        weight: "3 medium capsicums (approx. 450 g)",
        shelf_life: "5-7 days (refrigerated)",
        nutrition: {
          calories: "31 kcal",
          carbs: "6g",
          fiber: "2.1g",
          sugar: "4.2g",
          protein: "1g",
        },
        tags: ["Vitamin C", "Colourful", "Antioxidant"],
      },
    },
  ],
  dairy: [
    {
      id: 8,
      name: "Milk",
      price: 35,
      unit: "1 litre",
      image: "https://images.unsplash.com/photo-1563636619-e9143da7973b?w=500",
      category: "dairy",
      details: {
        description:
          "Full-cream fresh cow milk, pasteurised and homogenised. Rich in calcium and essential vitamins.",
        origin: "Local Dairy Farm, Gujarat",
        weight: "1 litre pack",
        shelf_life: "2-3 days (refrigerated)",
        nutrition: {
          calories: "61 kcal",
          carbs: "4.8g",
          fiber: "0g",
          sugar: "5g",
          protein: "3.2g",
        },
        tags: ["Calcium Rich", "Full Cream", "Fresh Daily"],
      },
    },
    {
      id: 9,
      name: "Cheese",
      price: 45,
      unit: "200 g block",
      image:
        "https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=500",
      category: "dairy",
      soldOut: true,
      details: {
        description:
          "Premium processed cheese block. Smooth, mild flavour - perfect for sandwiches, pizzas, and pasta.",
        origin: "Amul, Gujarat",
        weight: "200 g block",
        shelf_life: "30 days (refrigerated, unopened)",
        nutrition: {
          calories: "402 kcal",
          carbs: "1.3g",
          fiber: "0g",
          sugar: "0.5g",
          protein: "25g",
        },
        tags: ["High Protein", "Processed", "Kid Friendly"],
      },
    },

    {
      id: 19,
      name: "Butter",
      price: 35,
      unit: "100 g",
      image:
        "https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=500",
      category: "dairy",
      details: {
        description:
          "Rich, salted creamery butter made from pasteurised cream. Adds depth to rotis, parathas, and baked goods.",
        origin: "Amul, Gujarat",
        weight: "100 g pack",
        shelf_life: "14 days (refrigerated)",
        nutrition: {
          calories: "717 kcal",
          carbs: "0.1g",
          fiber: "0g",
          sugar: "0.1g",
          protein: "0.9g",
        },
        tags: ["Creamery", "Salted", "Baking Essential"],
      },
    },
    {
      id: 20,
      name: "Eggs (12pk)",
      price: 40,
      unit: "12 eggs",
      image:
        "https://images.unsplash.com/photo-1506976785307-8732e854ad03?w=500",
      category: "dairy",
      details: {
        description:
          "Farm-fresh free-range eggs. High in protein and essential amino acids. Ideal for all cooking needs.",
        origin: "Local Farm, Pune",
        weight: "12 eggs (approx. 720 g)",
        shelf_life: "21 days (refrigerated)",
        nutrition: {
          calories: "155 kcal",
          carbs: "1.1g",
          fiber: "0g",
          sugar: "1.1g",
          protein: "13g",
        },
        tags: ["High Protein", "Free Range", "Omega-3"],
      },
    },
    {
      id: 21,
      name: "Ice Cream",
      price: 40,
      unit: "500 ml tub",
      image:
        "https://images.unsplash.com/photo-1501443762994-82bd5dace89a?w=500",
      category: "dairy",
      details: {
        description:
          "Velvety vanilla ice cream made with real milk and cream. The perfect treat for any occasion.",
        origin: "Kwality Walls / Amul",
        weight: "500 ml tub",
        shelf_life: "6 months (frozen)",
        nutrition: {
          calories: "207 kcal",
          carbs: "24g",
          fiber: "0.5g",
          sugar: "21g",
          protein: "3.5g",
        },
        tags: ["Dessert", "Creamy", "Frozen Treat"],
      },
    },

    {
      id: 32,
      name: "Ghee",
      price: 120,
      unit: "500 ml jar",
      image:
        "https://images.unsplash.com/photo-1624528733107-2571fc0a8434?q=80&w=2137&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
      category: "dairy",
      details: {
        description:
          "Pure, golden cow's milk ghee slow-cooked to perfection. Rich nutty aroma and flavour — the soul of Indian cooking. Use for tempering, rotis, dal, or Ayurvedic rituals.",
        origin: "Amul / Patanjali, India",
        weight: "500 ml jar",
        shelf_life: "12 months (at room temperature)",
        nutrition: {
          calories: "900 kcal",
          carbs: "0g",
          fiber: "0g",
          sugar: "0g",
          protein: "0g",
        },
        tags: ["Pure Cow Ghee", "Ayurvedic", "Kitchen Essential"],
      },
    },
    {
      id: 40,
      name: "peda",
      price: 45,
      unit: "200 ml",
      image:
        "https://media.istockphoto.com/id/2001726059/photo/peda-sweet.webp?a=1&b=1&s=612x612&w=0&k=20&c=N90bUjhO_A-mWefsyRibrnkzPp3lgMPVr4vMQ_KydZU=",
      category: "dairy",
      details: {
        description:
          "Thick, velvety fresh cream skimmed from whole milk. Adds richness to curries, kormas, soups, and desserts. Also great whipped as a topping.",
        origin: "Amul, Gujarat",
        weight: "200 ml carton",
        shelf_life: "7 days (refrigerated)",
        nutrition: {
          calories: "195 kcal",
          carbs: "3g",
          fiber: "0g",
          sugar: "3g",
          protein: "2.1g",
        },
        tags: ["Rich & Creamy", "Cooking Essential", "High Fat"],
      },
    },
    {
      id: 41,
      name: "Buttermilk (Chaas)",
      price: 25,
      unit: "500 ml",
      image: "https://images.unsplash.com/photo-1550583724-b2692b85b150?w=500",
      category: "dairy",
      details: {
        description:
          "Chilled, spiced chaas made from churned dahi with jeera, ginger and curry leaves. A refreshing digestive drink perfect with lunch or dinner.",
        origin: "Local Dairy, Gujarat",
        weight: "500 ml bottle",
        shelf_life: "3 days (refrigerated)",
        nutrition: {
          calories: "40 kcal",
          carbs: "4.8g",
          fiber: "0g",
          sugar: "4.5g",
          protein: "3.3g",
        },
        tags: ["Digestive", "Cooling Drink", "Low Calorie"],
      },
    },
    {
      id: 42,
      name: "Lassi",
      price: 40,
      unit: "500 ml",
      image:
        "https://media.istockphoto.com/id/2214375556/photo/lassi-in-clay-cup-topped-with-dry-fruits.webp?a=1&b=1&s=612x612&w=0&k=20&c=OsxAg9ZKpsQI-lc4bcmujNQb6kQCPVUun4e_aHeEUMY=",
      category: "dairy",
      details: {
        description:
          "Frothy, sweet Punjabi lassi blended from fresh dahi and chilled milk. Topped with a dollop of malai — the ultimate summer cooler.",
        origin: "Punjab Dairy, India",
        weight: "500 ml bottle",
        shelf_life: "3 days (refrigerated)",
        nutrition: {
          calories: "70 kcal",
          carbs: "9g",
          fiber: "0g",
          sugar: "8.5g",
          protein: "3.5g",
        },
        tags: ["Refreshing", "Probiotic", "Traditional"],
      },
    },
    {
      id: 33,
      name: "Paneer",
      price: 80,
      unit: "200 g",
      image:
        "https://media.istockphoto.com/id/2209167127/photo/indian-paneer-cheese-made-from-fresh-milk-and-lemon-juice-on-grey-background-copy-space.webp?a=1&b=1&s=612x612&w=0&k=20&c=PAn7GuHgdN5S4hlXW2lQcUV-OGegD5GuLyvKf-fsr4E=",
      category: "dairy",
      details: {
        description:
          "Fresh, soft cottage cheese made from whole cow milk. Mildly flavoured and versatile - perfect for paneer butter masala, tikka, bhurji, or grilling.",
        origin: "Amul / Local Dairy, Gujarat",
        weight: "200 g block",
        shelf_life: "5-7 days (refrigerated)",
        nutrition: {
          calories: "265 kcal",
          carbs: "1.2g",
          fiber: "0g",
          sugar: "0.8g",
          protein: "18g",
        },
        tags: ["High Protein", "Vegetarian", "Indian Kitchen Staple"],
      },
    },
  ],
};

// (function injectStyles() {
//   const style = document.createElement("style");
//   style.textContent = `
//         /* unit chip */
//         .product-unit {
//             font-size: .78rem; 
//             color: #27ae60; 
//             font-weight: 600;
//             background: #eafaf1; 
//             border: 1px solid #b2dfca;
//             border-radius: 20px; 
//             padding: 2px 10px;
//             display: inline-block; 
//             margin: 4px 0 6px;
//         }
//         /* view details link */
//         .view-details-btn {
//             background: none; border: none; color: #2ecc71;
//             font-size: .82rem; font-weight: 600; cursor: pointer;
//             padding: 0; margin-top: 2px; text-decoration: underline;
//             font-family: inherit; display: block; margin-bottom: 4px;
//         }
//         .view-details-btn:hover { color: #27ae60; }

//         /* sold-out card */
//         .product-card { position: relative; }
//         .sold-out-ribbon {
//             position: absolute; top: 12px; right: -4px;
//             background: #e74c3c; color: white;
//             font-size: .7rem; font-weight: 700; letter-spacing: 1px;
//             text-transform: uppercase; padding: 4px 12px 4px 10px;
//             border-radius: 4px 0 0 4px;
//             box-shadow: -2px 2px 6px rgba(0,0,0,.15); z-index: 10;
//         }
//         .sold-out-ribbon::after {
//             content: ''; position: absolute; right: -6px; top: 0;
//             border-top: 12px solid transparent;
//             border-bottom: 12px solid transparent;
//             border-left: 6px solid #c0392b;
//         }
//         .product-card.is-sold-out img { filter: grayscale(60%) opacity(.7); }
//         .btn-sold-out {
//             background: #e2e8f0 !important; color: #a0aec0 !important;
//             cursor: not-allowed !important; border: none; border-radius: 8px;
//             padding: .55rem 1rem; font-size: .9rem; font-weight: 600;
//             width: 100%; display: flex; align-items: center;
//             justify-content: center; gap: .4rem; font-family: inherit;
//         }

//         /* ── SOLD-OUT MODAL ── */
//         #soldOutModal {
//             display: none; position: fixed; inset: 0;
//             background: rgba(0,0,0,.55); backdrop-filter: blur(6px);
//             z-index: 99999; align-items: center; justify-content: center;
//         }
//         #soldOutModal.show { display: flex; animation: soFadeIn .22s ease; }
//         @keyframes soFadeIn { from{opacity:0} to{opacity:1} }
//         .so-box {
//             background: #fff; border-radius: 22px;
//             padding: 2.4rem 2.2rem 2rem; max-width: 380px; width: 92%;
//             text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,.18);
//             animation: soPop .35s cubic-bezier(.175,.885,.32,1.275);
//             position: relative; overflow: hidden;
//         }
//         @keyframes soPop { from{transform:scale(.72) translateY(20px);opacity:0} to{transform:scale(1) translateY(0);opacity:1} }
//         .so-box::before {
//             content: ''; position: absolute; top: 0; left: 0; right: 0;
//             height: 5px; background: linear-gradient(90deg,#e74c3c,#c0392b);
//             border-radius: 22px 22px 0 0;
//         }
//         .so-icon-wrap {
//             width: 82px; height: 82px;
//             background: linear-gradient(135deg,#fde8e8,#fbc4c4);
//             border-radius: 50%; display: flex; align-items: center;
//             justify-content: center; margin: 0 auto 1.1rem;
//             animation: soWiggle .5s ease .2s;
//         }
//         @keyframes soWiggle { 0%,100%{transform:rotate(0)} 25%{transform:rotate(-8deg)} 75%{transform:rotate(8deg)} }
//         .so-icon-wrap ion-icon { font-size: 2.6rem; color: #e74c3c; }
//         .so-box h2 { font-family:'Playfair Display',serif; font-size:1.65rem; color:#2d3748; margin-bottom:.45rem; }
//         .so-product-name {
//             display: inline-block; font-weight: 700; color: #e74c3c;
//             background: #fef2f2; border: 1px dashed #fca5a5;
//             border-radius: 6px; padding: 3px 12px; font-size: .95rem; margin-bottom: .75rem;
//         }
//         .so-box p { color: #718096; font-size: .9rem; line-height: 1.6; margin-bottom: 1.4rem; }
//         .so-actions { display: flex; gap: .75rem; }
//         .so-btn-close {
//             flex: 1; padding: .75rem; border: 1.5px solid #e2e8f0;
//             border-radius: 10px; background: #f8f8f8; color: #555;
//             font-size: .9rem; font-weight: 600; cursor: pointer; font-family: inherit;
//         }
//         .so-btn-close:hover { background: #eee; }
//         .so-btn-shop {
//             flex: 1; padding: .75rem; border: none; border-radius: 10px;
//             background: linear-gradient(135deg,#2ecc71,#27ae60);
//             color: white; font-size: .9rem; font-weight: 700; cursor: pointer;
//             font-family: inherit; box-shadow: 0 4px 14px rgba(46,204,113,.35);
//             transition: all .25s;
//         }
//         .so-btn-shop:hover { transform: translateY(-2px); }

//         /* ── PRODUCT DETAILS MODAL ── */
//         #productDetailsModal {
//             display: none; position: fixed; inset: 0;
//             background: rgba(0,0,0,.6); backdrop-filter: blur(8px);
//             z-index: 99998; align-items: center; justify-content: center; padding: 1rem;
//         }
//         #productDetailsModal.show { display: flex; animation: soFadeIn .22s ease; }
//         .pd-box {
//             background: #fff; border-radius: 20px; max-width: 560px; width: 100%;
//             box-shadow: 0 24px 80px rgba(0,0,0,.2);
//             animation: soPop .35s cubic-bezier(.175,.885,.32,1.275);
//             overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;
//         }
//         .pd-img-wrap { position: relative; flex-shrink: 0; height: 220px; overflow: hidden; }
//         .pd-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
//         .pd-close {
//             position: absolute; top: 12px; right: 12px;
//             width: 34px; height: 34px; border-radius: 50%;
//             background: rgba(0,0,0,.45); border: none; cursor: pointer;
//             display: flex; align-items: center; justify-content: center;
//             color: white; font-size: 1.3rem; transition: background .2s;
//         }
//         .pd-close:hover { background: rgba(0,0,0,.7); }
//         .pd-so-overlay {
//             position: absolute; inset: 0; background: rgba(0,0,0,.4);
//             display: flex; align-items: center; justify-content: center;
//         }
//         .pd-so-overlay span {
//             background: #e74c3c; color: white; font-size: 1.1rem; font-weight: 800;
//             letter-spacing: 2px; padding: 8px 24px; border-radius: 8px;
//             text-transform: uppercase; box-shadow: 0 4px 16px rgba(0,0,0,.3);
//         }
//         .pd-body { padding: 1.4rem 1.6rem 1.8rem; overflow-y: auto; }
//         .pd-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: .6rem; }
//         .pd-title { font-family:'Playfair Display',serif; font-size: 1.5rem; color: #2d3748; margin: 0; }
//         .pd-price-block { text-align: right; flex-shrink: 0; }
//         .pd-price { font-size: 1.4rem; font-weight: 800; color: #27ae60; }
//         .pd-unit-badge {
//             display: inline-block; font-size: .75rem; font-weight: 700;
//             color: #27ae60; background: #eafaf1; border: 1px solid #b2dfca;
//             border-radius: 20px; padding: 2px 10px; margin-top: 3px;
//         }
//         .pd-desc { color: #555; font-size: .93rem; line-height: 1.65; margin: .5rem 0 1.1rem; }
//         .pd-tags { display: flex; flex-wrap: wrap; gap: .45rem; margin-bottom: 1.1rem; }
//         .pd-tag {
//             background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a;
//             font-size: .76rem; font-weight: 600; border-radius: 20px; padding: 3px 10px;
//         }
//         .pd-info-grid {
//             display: grid; grid-template-columns: 1fr 1fr;
//             gap: .55rem; margin-bottom: 1.2rem;
//         }
//         .pd-info-item {
//             background: #fafafa; border: 1px solid #e2e8f0;
//             border-radius: 10px; padding: .65rem .85rem;
//         }
//         .pd-info-item .pi-label {
//             font-size: .72rem; font-weight: 700; color: #718096;
//             text-transform: uppercase; letter-spacing: .5px; margin-bottom: 2px;
//         }
//         .pd-info-item .pi-value { font-size: .88rem; font-weight: 600; color: #2d3748; }
//         .pd-nutrition h4 {
//             font-size: .85rem; font-weight: 700; color: #2d3748;
//             text-transform: uppercase; letter-spacing: .5px;
//             margin-bottom: .55rem; display: flex; align-items: center; gap: .4rem;
//         }
//         .pd-nutrition h4 ion-icon { color: #2ecc71; }
//         .pd-nut-grid {
//             display: grid; grid-template-columns: repeat(5,1fr); gap: .4rem; text-align: center;
//         }
//         .pd-nut-item {
//             background: linear-gradient(135deg,#f0fdf4,#dcfce7);
//             border: 1px solid #bbf7d0; border-radius: 10px; padding: .55rem .3rem;
//         }
//         .pd-nut-item .n-val { font-size: .88rem; font-weight: 800; color: #27ae60; }
//         .pd-nut-item .n-lbl { font-size: .68rem; color: #718096; margin-top: 2px; }
//         .pd-footer {
//             padding: 1rem 1.6rem 1.4rem; border-top: 1px solid #e2e8f0;
//             display: flex; gap: .75rem; flex-shrink: 0;
//         }
//         .pd-btn-close {
//             flex: 0 0 auto; padding: .75rem 1.2rem;
//             border: 1.5px solid #e2e8f0; border-radius: 10px;
//             background: #f8f8f8; color: #555;
//             font-size: .9rem; font-weight: 600; cursor: pointer; font-family: inherit;
//         }
//         .pd-btn-close:hover { background: #eee; }
//         .pd-btn-cart {
//             flex: 1; padding: .75rem; border: none; border-radius: 10px;
//             background: linear-gradient(135deg,#2ecc71,#27ae60);
//             color: white; font-size: .95rem; font-weight: 700; cursor: pointer;
//             font-family: inherit; display: flex; align-items: center;
//             justify-content: center; gap: .5rem;
//             box-shadow: 0 4px 14px rgba(46,204,113,.35); transition: all .25s;
//         }
//         .pd-btn-cart:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(46,204,113,.45); }
//         .pd-btn-cart.disabled {
//             background: #e2e8f0 !important; color: #a0aec0 !important;
//             cursor: not-allowed !important; box-shadow: none !important; transform: none !important;
//         }
//         @media(max-width:480px){
//             .pd-nut-grid { grid-template-columns: repeat(3,1fr); }
//             .pd-info-grid { grid-template-columns: 1fr; }
//             .pd-header { flex-direction: column; }
//         }
//     `;
//   document.head.appendChild(style);
// })();

// Option A: Use getClass().getResource() for files inside the JAR/project
scene.getStylesheets().add(getClass().getResource("stylejs.css").toExternalForm());

// Option B: For files outside the project directory
// File f = new File("page-specific/stylejs.css");
// scene.getStylesheets().add("file:///" + f.getAbsolutePath().replace("\\", "/"));


(function injectSoldOutModal() {
  const modal = document.createElement("div");
  modal.id = "soldOutModal";
  modal.innerHTML = `
        <div class="so-box">
            <div class="so-icon-wrap"><ion-icon name="ban-outline"></ion-icon></div>
            <h2>Sold Out!</h2>
            <div id="soProductName" class="so-product-name"></div>
            <p>Sorry, this item is currently out of stock.<br>Check back soon - we restock regularly!</p>
            <div class="so-actions">
                <button class="so-btn-close" onclick="closeSoldOutModal()">Got It</button>
                <button class="so-btn-shop" onclick="closeSoldOutModal();scrollToProducts()">Browse Items</button>
            </div>
        </div>`;
  document.body.appendChild(modal);
  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeSoldOutModal();
  });
})();

// ═══════════════════════════════════════════════════
//  PRODUCT DETAILS MODAL
// ═══════════════════════════════════════════════════
(function injectDetailsModal() {
  const modal = document.createElement("div");
  modal.id = "productDetailsModal";
  modal.innerHTML = `
        <div class="pd-box">
            <div class="pd-img-wrap">
                <img id="pdImage" src="" alt="">
                <button class="pd-close" onclick="closeDetailsModal()">
                    <ion-icon name="close-outline"></ion-icon>
                </button>
                <div id="pdSoldOutOverlay" class="pd-so-overlay" style="display:none">
                    <span>Sold Out</span>
                </div>
            </div>
            <div class="pd-body">
                <div class="pd-header">
                    <h2 class="pd-title" id="pdName"></h2>
                    <div class="pd-price-block">
                        <div class="pd-price" id="pdPrice"></div>
                        <div class="pd-unit-badge" id="pdUnit"></div>
                    </div>
                </div>
                <p class="pd-desc" id="pdDesc"></p>
                <div class="pd-tags" id="pdTags"></div>
                <div class="pd-info-grid" id="pdInfoGrid"></div>
                <div class="pd-nutrition" id="pdNutrition"></div>
            </div>
            <div class="pd-footer">
                <button class="pd-btn-close" onclick="closeDetailsModal()">Close</button>
                <button class="pd-btn-cart" id="pdCartBtn">
                    <ion-icon name="cart-outline"></ion-icon> Add to Cart
                </button>
            </div>
        </div>`;
  document.body.appendChild(modal);
  modal.addEventListener("click", (e) => {
    if (e.target === modal) closeDetailsModal();
  });
})();

// ── Sold-out helpers ──────────────────────────────────
function showSoldOutModal(productName) {
  document.getElementById("soProductName").textContent = productName;
  document.getElementById("soldOutModal").classList.add("show");
  document.body.style.overflow = "hidden";
}
function closeSoldOutModal() {
  document.getElementById("soldOutModal").classList.remove("show");
  document.body.style.overflow = "";
}
function scrollToProducts() {
  const sec = document.querySelector(".products-container");
  if (sec) sec.scrollIntoView({ behavior: "smooth", block: "start" });
}

// ── Details modal helpers ─────────────────────────────
function openDetailsModal(productId) {
  const product = Object.values(products)
    .flat()
    .find((p) => p.id === productId);
  if (!product) return;
  const d = product.details || {};
  const nut = d.nutrition || {};

  document.getElementById("pdImage").src = product.image;
  document.getElementById("pdImage").alt = product.name;
  document.getElementById("pdName").textContent = product.name;
  document.getElementById("pdPrice").textContent =
    "Rs." + product.price.toFixed(2);
  document.getElementById("pdUnit").textContent = product.unit || "";
  document.getElementById("pdDesc").textContent = d.description || "";
  document.getElementById("pdSoldOutOverlay").style.display = product.soldOut
    ? "flex"
    : "none";

  // tags
  document.getElementById("pdTags").innerHTML = (d.tags || [])
    .map((t) => `<span class="pd-tag">${t}</span>`)
    .join("");

  // info grid
  document.getElementById("pdInfoGrid").innerHTML = [
    { label: "Origin", value: d.origin || "-" },
    { label: "Weight / Pack", value: d.weight || product.unit || "-" },
    { label: "Shelf Life", value: d.shelf_life || "-" },
    {
      label: "Category",
      value:
        product.category.charAt(0).toUpperCase() + product.category.slice(1),
    },
  ]
    .map(
      (i) => `
        <div class="pd-info-item">
            <div class="pi-label">${i.label}</div>
            <div class="pi-value">${i.value}</div>
        </div>`,
    )
    .join("");

  // nutrition
  document.getElementById("pdNutrition").innerHTML = `
        <h4><ion-icon name="nutrition-outline"></ion-icon> Nutrition (per 100 g)</h4>
        <div class="pd-nut-grid">
            ${[
              { val: nut.calories || "-", lbl: "Calories" },
              { val: nut.carbs || "-", lbl: "Carbs" },
              { val: nut.fiber || "-", lbl: "Fiber" },
              { val: nut.sugar || "-", lbl: "Sugar" },
              { val: nut.protein || "-", lbl: "Protein" },
            ]
              .map(
                (n) => `
                <div class="pd-nut-item">
                    <div class="n-val">${n.val}</div>
                    <div class="n-lbl">${n.lbl}</div>
                </div>`,
              )
              .join("")}
        </div>`;

  // cart button
  const btn = document.getElementById("pdCartBtn");
  if (product.soldOut) {
    btn.className = "pd-btn-cart disabled";
    btn.innerHTML =
      '<ion-icon name="close-circle-outline"></ion-icon> Sold Out';
    btn.onclick = null;
  } else {
    btn.className = "pd-btn-cart";
    btn.innerHTML = '<ion-icon name="cart-outline"></ion-icon> Add to Cart';
    btn.onclick = () => {
      closeDetailsModal();
      addToCart(product.id);
    };
  }

  document.getElementById("productDetailsModal").classList.add("show");
  document.body.style.overflow = "hidden";
}
function closeDetailsModal() {
  document.getElementById("productDetailsModal").classList.remove("show");
  document.body.style.overflow = "";
}

// ═══════════════════════════════════════════════════
//  CART
// ═══════════════════════════════════════════════════
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function updateCartCount() {
  const el = document.getElementById("cartCount");
  if (el) el.textContent = cart.reduce((t, i) => t + i.quantity, 0);
}

function addToCart(productId) {
  const product = Object.values(products)
    .flat()
    .find((p) => p.id === productId);
  if (!product) return;
  if (product.soldOut) {
    showSoldOutModal(product.name);
    return;
  }
  const existing = cart.find((i) => i.id === productId);
  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({ ...product, quantity: 1 });
  }
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();
  alert("Product added to cart!");
}

// ═══════════════════════════════════════════════════
//  BUILD PRODUCT CARD
// ═══════════════════════════════════════════════════
function buildProductCard(product) {
  const isSO = !!product.soldOut;
  const card = document.createElement("div");
  card.className = "product-card" + (isSO ? " is-sold-out" : "");

  card.innerHTML = `
        ${isSO ? '<div class="sold-out-ribbon">Sold Out</div>' : ""}
        <img src="${product.image}" alt="${product.name}">
        <h3>${product.name}</h3>
        <span class="product-unit">${product.unit || ""}</span>
        <p class="price">Rs.${product.price.toFixed(2)}</p>
        <button class="view-details-btn" onclick="openDetailsModal(${product.id})">View Details</button>
        ${
          isSO
            ? `<button class="btn-sold-out" onclick="showSoldOutModal('${product.name}')">
                   <ion-icon name="close-circle-outline"></ion-icon> Sold Out
               </button>`
            : `<button class="add-to-cart" onclick="addToCart(${product.id})">Add to Cart</button>`
        }
    `;
  return card;
}

// ═══════════════════════════════════════════════════
//  DISPLAY FUNCTIONS
// ═══════════════════════════════════════════════════
function displayCategories() {
  const container = document.querySelector(".category-container");
  if (!container) return;
  Object.keys(products).forEach((category) => {
    const card = document.createElement("div");
    card.className = "category-card";
    card.innerHTML = `
            <h3>${category.charAt(0).toUpperCase() + category.slice(1)}</h3>
            <p>${products[category].length} items</p>`;
    card.addEventListener("click", () => displayProducts(category));
    container.appendChild(card);
  });
}

function displayProducts(category = null) {
  const container = document.querySelector(".products-container");
  if (!container) return;
  container.innerHTML = "";
  const list = category ? products[category] : Object.values(products).flat();
  list.forEach((p) => container.appendChild(buildProductCard(p)));
}

function displayCart() {
  const cartContainer = document.querySelector(".cart-container");
  const cartTotal = document.getElementById("cartTotal");
  if (!cartContainer) return;
  if (cart.length === 0) {
    cartContainer.innerHTML = "<p>Your cart is empty</p>";
    if (cartTotal) cartTotal.textContent = "0.00";
    return;
  }
  cartContainer.innerHTML = "";
  let total = 0;
  cart.forEach((item) => {
    total += item.price * item.quantity;
    const el = document.createElement("div");
    el.className = "cart-item";
    el.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div class="cart-item-details">
                <h3>${item.name}</h3>
                <p>Rs.${item.price.toFixed(2)} x ${item.quantity}</p>
                <div class="cart-item-quantity">
                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                    <button onclick="removeFromCart(${item.id})">Remove</button>
                </div>
            </div>`;
    cartContainer.appendChild(el);
  });
  if (cartTotal) cartTotal.textContent = total.toFixed(2);
}

function updateQuantity(productId, newQuantity) {
  if (newQuantity < 1) {
    removeFromCart(productId);
    return;
  }
  const item = cart.find((i) => i.id === productId);
  if (item) {
    item.quantity = newQuantity;
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    displayCart();
  }
}

function removeFromCart(productId) {
  cart = cart.filter((i) => i.id !== productId);
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();
  displayCart();
}

//  SEARCH

function setupSearch() {
  const searchInput = document.getElementById("searchInput");
  if (!searchInput) return;
  searchInput.addEventListener("input", (e) => {
    const term = e.target.value.toLowerCase();
    const filtered = Object.values(products)
      .flat()
      .filter(
        (p) =>
          p.name.toLowerCase().includes(term) ||
          p.category.toLowerCase().includes(term),
      );
    const container = document.querySelector(".products-container");
    if (!container) return;
    container.innerHTML = "";
    filtered.forEach((p) => container.appendChild(buildProductCard(p)));
  });
}


//  INIT

document.addEventListener("DOMContentLoaded", () => {
  updateCartCount();
  displayProducts();
  displayCategories();
  displayCart();
  setupSearch();
});
