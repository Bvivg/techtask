export default interface IDomain {
  id: number;
  domain: string;
  status: 'available' | 'busy' | 'expired' | 'banned';
  expires_at: string | null; 
  user_id: number | null;
  created_at: string;
  updated_at: string;
}
