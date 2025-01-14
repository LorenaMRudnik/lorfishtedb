const express = require('express');
const router = express.Router();
const {
    fish_name,
    fish_order,
    fish_class,
    fish_superfamily,
    fish_table_order,
    fish_table_class,
    fish_table_superfamily
} = require('../controllers/searchController');


router.get('/fish_name', fish_name);

router.get('/fish_order', fish_order);

router.get('/fish_class', fish_class);

router.get('/fish_superfamily', fish_superfamily);

router.get('/fish_table/order', fish_table_order);

router.get('/fish_table/class', fish_table_class);

router.get('/fish_table/superfamily', fish_table_superfamily);

module.exports = router;