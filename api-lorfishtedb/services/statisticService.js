const pg = require('../config/database');

class Statistic {
    data_fish(req, res, fish) {
        const sql = 'SELECT superfamily_name, COUNT(*) AS count FROM analysis_info WHERE scientific_name_fish = $1 GROUP BY superfamily_name ORDER BY count DESC';
        const values = [fish];

        pg.query(sql, values, (err, result) => {
            if (err) {
                console.error(err);
                return res.status(400).json({ error: 'An error occurred' });
            } else {
                return res.status(200).json(result.rows);
            }
        });
    }
    

}

module.exports = new Statistic();