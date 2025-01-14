const pg = require('../config/database');

class Search {
    fish_name(req, res) {
        const sql = 'SELECT scientific_name_fish FROM specie_fish'; 
        pg.query(sql, (err, result) => {
            if (err) {
                console.error(err);
                return res.status(400).json({ error: 'An error occurred' });
            } else {
                return res.status(200).json(result.rows);
            }
        });
    }

    fish_order(req, res) {
        const sql = 'SELECT order_name FROM order_wicker'; 
        pg.query(sql, (err, result) => {
            if (err) {
                console.error(err);
                return res.status(400).json({ error: 'An error occurred' });
            } else {
                return res.status(200).json(result.rows);
            }
        });
    }

    fish_class(req, res) {
        const sql = 'SELECT class_name FROM class_wicker'; 
        pg.query(sql, (err, result) => {
            if (err) {
                console.error(err);
                return res.status(400).json({ error: 'An error occurred' });
            } else {
                return res.status(200).json(result.rows);
            }
        });
    }

    fish_superfamily(req, res) {
        const sql = 'SELECT superfamily_name FROM superfamily_wicker'; 
        pg.query(sql, (err, result) => {
            if (err) {
                console.error(err);
                return res.status(400).json({ error: 'An error occurred SERVICE' });
            } else {
                return res.status(200).json(result.rows);
            }
        });
    }
    fish_table_order(req, res, name_fish, order) {
        const sql = 'SELECT * FROM analysis_info WHERE scientific_name_fish = $1 AND order_name = $2';
        const values = [name_fish, order];
    
        // Log os valores enviados para verificar se estão corretos
        console.log('Query Values:', values);
    
        pg.query(sql, values, (err, result) => {
            if (err) {
                console.error('Database Error:', err);
                console.error('Failed Query Values:', values); // Exibe os valores em caso de erro
                return res.status(400).json({ error: `An error occurred - Service`, values });
            } else {
                return res.status(200).json(result.rows);
            }
        });
    }

    fish_table_class(req, res, name_fish, class_name) {
        const sql = 'SELECT * FROM analysis_info WHERE scientific_name_fish = $1 AND class_name = $2';
        const values = [name_fish, class_name];

        // Log os valores enviados para verificar se estão corretos
        console.log('Query Values:', values);

        pg.query(sql, values, (err, result) => {
            if (err) {
                console.error('Database Error:', err);
                console.error('Failed Query Values:', values); // Exibe os valores em caso de erro
                return res.status(400).json({ error: `An error occurred - Service`, values });
            } else {
                return res.status(200).json(result.rows);
            }
    });
}

    fish_table_superfamily(req, res, name_fish, superfamily) {
        const sql = 'SELECT * FROM analysis_info WHERE scientific_name_fish = $1 AND superfamily_name = $2';
        const values = [name_fish, superfamily];

        // Log os valores enviados para verificar se estão corretos
        console.log('Query Values:', values);

        pg.query(sql, values, (err, result) => {
            if (err) {
                console.error('Database Error:', err);
                console.error('Failed Query Values:', values); // Exibe os valores em caso de erro
                return res.status(400).json({ error: `An error occurred - Service`, values });
            } else {
                return res.status(200).json(result.rows);
            }
        });
    }
}

module.exports = new Search(); // Exportando uma instância da classe
