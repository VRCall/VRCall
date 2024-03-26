import express, { Application } from 'express';
import cors from 'cors';

const app: Application = express();

const usersRouter = require("./routes/users/router")

const corsOptions = {
    origin: process.env.FRONTEND_BASE_URL
};

app.use(express.json());
app.use(cors(corsOptions));

const port = process.env.PORT || 8000;

app.use("/users", usersRouter.routes)

app.listen(port, () => {
    console.log(`App listening on port ${port}`);
});