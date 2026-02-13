import { useState, useEffect } from 'react';
import { Sport } from '../types';
import { sportService } from '../services/api';

export const useSports = () => {
  const [sports, setSports] = useState<Sport[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchSports = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await sportService.getAll();
      setSports(data);
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors du chargement des sports');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchSports();
  }, []);

  const createSport = async (name: string, sportType: string) => {
    try {
      const newSport = await sportService.create({ name, sportType });
      setSports((prev) => [...prev, newSport]);
      return newSport;
    } catch (err) {
      throw err instanceof Error ? err : new Error('Erreur lors de la création du sport');
    }
  };

  const deleteSport = async (id: number) => {
    try {
      await sportService.delete(id);
      setSports((prev) => prev.filter((s) => s.id !== id));
    } catch (err) {
      throw err instanceof Error ? err : new Error('Erreur lors de la suppression du sport');
    }
  };

  return {
    sports,
    loading,
    error,
    refetch: fetchSports,
    createSport,
    deleteSport,
  };
};
