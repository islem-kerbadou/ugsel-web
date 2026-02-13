import axios from 'axios';
import { Sport, SportType, Competition, Championship } from '../types';

const API_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api';

const apiClient = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/ld+json',
    'Accept': 'application/ld+json',
  },
});

const getCollectionMembers = (data: any): any[] => {
  return data['hydra:member'] || data.member || [];
};

export const sportTypeService = {
  getAll: async (): Promise<SportType[]> => {
    const response = await apiClient.get('/sport_types');
    return getCollectionMembers(response.data);
  },

  getById: async (id: number): Promise<SportType> => {
    const response = await apiClient.get(`/sport_types/${id}`);
    return response.data;
  },

  create: async (data: { code: string; label?: string; types?: ('individuel' | 'collectif')[] }): Promise<SportType> => {
    const response = await apiClient.post('/sport_types', {
      code: data.code,
      label: data.label,
      types: data.types,
    });
    return response.data;
  },
};

export const sportService = {
  getAll: async (): Promise<Sport[]> => {
    const response = await apiClient.get('/sports', {
      params: {
        'groups[]': ['sport:read'],
      },
    });
    return getCollectionMembers(response.data);
  },

  getById: async (id: number): Promise<Sport> => {
    const response = await apiClient.get(`/sports/${id}`, {
      params: {
        'groups[]': ['sport:read'],
      },
    });
    return response.data;
  },

  create: async (data: { name: string; sportType: string | string[] }): Promise<Sport> => {
    const response = await apiClient.post('/sports', {
      name: data.name,
      sportType: Array.isArray(data.sportType) ? data.sportType : [data.sportType],
    });
    return response.data;
  },

  update: async (id: number, data: Partial<Sport>): Promise<Sport> => {
    const response = await apiClient.put(`/sports/${id}`, data);
    return response.data;
  },

  delete: async (id: number): Promise<void> => {
    await apiClient.delete(`/sports/${id}`);
  },
};

export const competitionService = {
  getAll: async (): Promise<Competition[]> => {
    const response = await apiClient.get('/competitions');
    return getCollectionMembers(response.data);
  },

  getBySport: async (sportId: number): Promise<Competition[]> => {
    const response = await apiClient.get('/competitions', {
      params: {
        'sport.id': sportId,
      },
    });
    return getCollectionMembers(response.data);
  },

  create: async (data: { name: string; sport: string }): Promise<Competition> => {
    const response = await apiClient.post('/competitions', {
      name: data.name,
      sport: data.sport,
    });
    return response.data;
  },

  update: async (id: number, data: Partial<Competition>): Promise<Competition> => {
    const response = await apiClient.put(`/competitions/${id}`, data);
    return response.data;
  },

  delete: async (id: number): Promise<void> => {
    await apiClient.delete(`/competitions/${id}`);
  },
};

export const championshipService = {
  getAll: async (): Promise<Championship[]> => {
    const response = await apiClient.get('/championships');
    return getCollectionMembers(response.data);
  },

  getByCompetition: async (competitionId: number): Promise<Championship[]> => {
    const response = await apiClient.get('/championships', {
      params: {
        'competition.id': competitionId,
      },
    });
    return getCollectionMembers(response.data);
  },

  create: async (data: { name: string; competition: string }): Promise<Championship> => {
    const response = await apiClient.post('/championships', {
      name: data.name,
      competition: data.competition,
    });
    return response.data;
  },

  update: async (id: number, data: Partial<Championship>): Promise<Championship> => {
    const response = await apiClient.put(`/championships/${id}`, data);
    return response.data;
  },

  delete: async (id: number): Promise<void> => {
    await apiClient.delete(`/championships/${id}`);
  },
};
