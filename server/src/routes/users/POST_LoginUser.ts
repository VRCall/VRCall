import { Request, Response } from "express";
import prisma from "../../utils/prisma";
const bcrypt = require("bcrypt");
const jwt = require("jsonwebtoken")
import z from "zod";

const RegisterSchema = z.object({
    email: z.string().email(),
    password: z.string(),
})

module.exports = async (req: Request, res: Response) => {

    try {

        console.log(req.body);
        

        const { email, password } = req.body;

        const validatedFields = RegisterSchema.safeParse({
            email: email,
            password: password
        });

        if(!validatedFields.success) {
            return res.status(400).json({ message: validatedFields.error });
        }

        const user = await prisma.user.findUnique({
            where: {
                email: validatedFields.data.email,
            }
        });

        if(!user) {
            return res.status(401).json({ message: "User doesn't exist" });
        }

        const validPassword = await bcrypt.compare(validatedFields.data.password, user.password);

        if (!validPassword) {
            return res.status(401).json({message: "Passwords don't match"});
        }

        const token = jwt.sign(
            { userId: user.id, email: user.email },
            process.env.JWT_SECRET_KEY,
            { expiresIn: "1d" }
        )

        return res.status(200).json({ user, token: token });

    }
    catch(error: any) {
        console.log("Error : " + error);
        return res.status(500).json({ message: "An error occured : " + error });
    }

}