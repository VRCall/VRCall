import { Request, Response } from "express";
import prisma from "../../utils/prisma";
const bcrypt = require("bcrypt");

module.exports = async (req: Request, res: Response) => {

    try {

        const { pseudo, email, password, profilePicture } = req.body;

        const userExists = await prisma.user.findFirst({
            where: {
                OR: [
                    { email: email },
                    { pseudo: pseudo }
                ]
            }
        });

        if(userExists !== null) {
            return res.status(400).json({ message: "Already in use" });
        }

        const hashedPassword = await bcrypt.hash(password, parseInt(process.env.SALTS!));

        await prisma.user.create({
            data: {
                pseudo: pseudo,
                email: email,
                password: hashedPassword,
                img: profilePicture
            }
        });

        return res.status(201);

    }
    catch(error: any) {
        console.log("Error : " + error);
        return res.status(500).json({ message: "An error occured : " + error });
    }

}