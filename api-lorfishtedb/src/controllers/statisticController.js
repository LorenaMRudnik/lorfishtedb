const statistic = require('../../services/statisticService');

exports.data_fish = (req, res) => {

    const fish = req.query.scientific_name_fish;

    try {
        statistic.data_fish(req, res, fish);  
    } catch (err) {
        console.error(err);
        res.status(500).send('An error occurred');
    }
}