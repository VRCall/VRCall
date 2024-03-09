import express, { Application } from 'express';
import cors from 'cors';
import prisma from './utils/prisma';

const app: Application = express();

const corsOptions = {
    origin: process.env.FRONTEND_BASE_URL
};

app.use(express.json());
app.use(cors(corsOptions));

const port = process.env.PORT || 8000;

app.get('/', async (req, res) => {
    const user = await prisma.user.findFirst({
        include: {
            posts: true
        }
    });
    return res.status(200).json(user);
});

app.listen(port, () => {
    console.log(`App listening on port ${port}`);
});