import React from 'react';
import { Sport } from '../../types';
import { SportCard } from './SportCard';
import { LoadingSpinner } from '../common/LoadingSpinner';
import { ErrorMessage } from '../common/ErrorMessage';

interface SportListProps {
  sports: Sport[];
  loading: boolean;
  error: string | null;
  onDeleteSport: (id: number) => void;
}

export const SportList: React.FC<SportListProps> = ({
  sports,
  loading,
  error,
  onDeleteSport,
}) => {
  if (loading) {
    return <LoadingSpinner />;
  }

  if (error) {
    return <ErrorMessage message={error} />;
  }

  if (sports.length === 0) {
    return (
      <div className="text-center p-5">
        <p className="text-muted">Aucun sport créé pour le moment.</p>
        <p className="text-muted">Créez votre premier sport en utilisant le formulaire ci-dessus.</p>
      </div>
    );
  }

  return (
    <div className="mt-4">
      <h2 className="mb-4">Liste des sports ({sports.length})</h2>
      {sports.map((sport) => (
        <SportCard key={sport.id} sport={sport} onDelete={onDeleteSport} />
      ))}
    </div>
  );
};
