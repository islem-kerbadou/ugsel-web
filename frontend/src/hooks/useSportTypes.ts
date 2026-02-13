import { useState, useEffect } from 'react';
import { SportType } from '../types';
import { sportTypeService } from '../services/api';

export const useSportTypes = () => {
  const [sportTypes, setSportTypes] = useState<SportType[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchSportTypes = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await sportTypeService.getAll();
      setSportTypes(data);
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors du chargement des types de sport');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchSportTypes();
  }, []);

  const createSportType = async (code: string, label?: string, types?: ('individuel' | 'collectif')[]) => {
    try {
      const newSportType = await sportTypeService.create({ code, label, types });
      setSportTypes((prev) => [...prev, newSportType]);
      return newSportType;
    } catch (err) {
      throw err instanceof Error ? err : new Error('Erreur lors de la création du type de sport');
    }
  };

  return {
    sportTypes,
    loading,
    error,
    refetch: fetchSportTypes,
    createSportType,
  };
};
