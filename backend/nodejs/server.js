const express = require('express');
const mysql = require('mysql2/promise');
const jwt = require('jsonwebtoken');
const cors = require('cors');
const dotenv = require('dotenv');
const bcrypt = require('bcrypt');

dotenv.config();

const app = express();

// Middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// MySQL Connection Pool
const pool = mysql.createPool({
    host: process.env.DB_HOST || 'localhost',
    user: process.env.DB_USER || 'root',
    password: process.env.DB_PASS || '',
    database: process.env.DB_NAME || 'college_voting_system',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

// JWT Secret
const JWT_SECRET = process.env.JWT_SECRET || 'your_secret_key_change_in_production';

// Routes
// GET all candidates
app.get('/api/candidates', async (req, res) => {
    try {
        const connection = await pool.getConnection();
        const [rows] = await connection.query(
            'SELECT c.id, c.position, c.manifesto, c.votes_count, u.full_name FROM candidates c JOIN users u ON c.user_id = u.id WHERE c.status = "active"'
        );
        connection.release();
        res.json({ status: 'success', data: rows });
    } catch (error) {
        res.status(500).json({ status: 'error', message: error.message });
    }
});

// GET user details
app.get('/api/users/:id', async (req, res) => {
    try {
        const connection = await pool.getConnection();
        const [rows] = await connection.query(
            'SELECT id, username, email, full_name, role, department FROM users WHERE id = ?',
            [req.params.id]
        );
        connection.release();

        if (rows.length === 0) {
            return res.status(404).json({ status: 'error', message: 'User not found' });
        }

        res.json({ status: 'success', data: rows[0] });
    } catch (error) {
        res.status(500).json({ status: 'error', message: error.message });
    }
});

// POST vote
app.post('/api/votes', async (req, res) => {
    const { voter_id, candidate_id } = req.body;

    if (!voter_id || !candidate_id) {
        return res.status(400).json({ status: 'error', message: 'Missing required fields' });
    }

    try {
        const connection = await pool.getConnection();

        // Check if already voted for this candidate
        const [existingVote] = await connection.query(
            'SELECT id FROM votes WHERE voter_id = ? AND candidate_id = ?',
            [voter_id, candidate_id]
        );

        if (existingVote.length > 0) {
            connection.release();
            return res.status(400).json({ status: 'error', message: 'Already voted for this candidate' });
        }

        // Insert vote
        await connection.query(
            'INSERT INTO votes (voter_id, candidate_id) VALUES (?, ?)',
            [voter_id, candidate_id]
        );

        // Update votes count
        await connection.query(
            'UPDATE candidates SET votes_count = votes_count + 1 WHERE id = ?',
            [candidate_id]
        );

        connection.release();
        res.json({ status: 'success', message: 'Vote recorded successfully' });
    } catch (error) {
        res.status(500).json({ status: 'error', message: error.message });
    }
});

// Health check
app.get('/api/health', (req, res) => {
    res.json({ status: 'success', message: 'Server is running' });
});

// Start Server
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});

module.exports = app;
