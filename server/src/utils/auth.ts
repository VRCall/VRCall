import { NextFunction, Request, Response } from "express";
import prisma from "./prisma";
const jwt = require("jsonwebtoken");

const authentication = async (req: Request, res: Response, next: NextFunction) => {

    try {
        const authToken = req.headers.authorization?.replace("Bearer", "")?.replace(" ", "");

        if(!authToken) {
            throw new Error("Not authorized");
        }

        const decodedToken: any = jwt.verify(authToken, process.env.JWT_SECRET_KEY);

        const user = await prisma.user.findUnique({
            where: {
                email: decodedToken.email
            }
        });

        if(!user) {
            throw new Error("Not authorized");
        }

        req.body.authToken = authToken;
        req.body.user = user;
        next();

    }
    catch(error: any) {
        res.json(false);
    }

}

export default authentication;