export default interface IUser {
  id: number;
  name: string;
  email: string;
  email_verified_at: string | null;
  password: string;
  remember_token: string;
  created_at: string;
  updated_at: string;
}
