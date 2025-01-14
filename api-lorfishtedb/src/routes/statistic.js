const express = require('express');
const router = express.Router();
const {
    data_fish
} = require('../controllers/statisticController');

router.get('/data', data_fish);

module.exports = router;
