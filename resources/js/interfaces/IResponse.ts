import IUser from "./IUser";

export default interface IResponse {
  token?: string;
  message: string;
  user?: IUser;
  error?: string;
}
