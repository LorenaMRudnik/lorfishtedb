const search = require('../../services/searchService');

exports.fish_name = (req, res)=> {
    try {
        search.fish_name(req, res);
    } catch (err) {
        console.error(err);
        res.status(500).send('An error occurred');
    }
}

exports.fish_order = (req, res) => {
    try {
        search.fish_order(req, res);
    } catch (err) {
        console.error(err);
        res.status(500).send('An error occurred');
    }
}

exports.fish_class = (req, res) => {
    try {
        search.fish_class(req, res);
    } catch (err) {
        console.error(err);
        res.status(500).send('An error occurred');
    }
}

exports.fish_superfamily = (req, res) => {
    try {
        search.fish_superfamily(req, res);
    } catch (err) {
        console.error(err);
        res.status(400).send('An error occurred CONTROLLER');
    }
}

exports.fish_table_order = (req, res) => {
    const name_fish = req.query.scientific_name_fish;
    const order = req.query.order_name;

    try {
        search.fish_table_order(req, res, name_fish, order);
    }catch(err) {
        console.error(err);
        res.status(500).send('An error occurred - Controller');
    }
}

exports.fish_table_class = (req, res) => {
    const name_fish = req.query.scientific_name_fish;
    const class_name = req.query.class_name;

    try {
        search.fish_table_class(req, res, name_fish, class_name);
    }catch(err) {
        console.error(err);
        res.status(500).send('An error occurred - Controller');
    }
}

exports.fish_table_superfamily = (req, res) => {
    const name_fish = req.query.scientific_name_fish;
    const superfamily_name = req.query.superfamily_name;

    try {
        search.fish_table_superfamily(req, res, name_fish, superfamily_name);
    }catch(err) {
        console.error(err);
        res.status(500).send('An error occurred - Controller');
    }
}