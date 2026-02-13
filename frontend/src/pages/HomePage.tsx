import React, { useState } from 'react';
import { SportForm } from '../components/sports/SportForm';
import { SportList } from '../components/sports/SportList';
import { SportTypeForm } from '../components/sport-types/SportTypeForm';
import { useSports } from '../hooks/useSports';
import { useSportTypes } from '../hooks/useSportTypes';

export const HomePage: React.FC = () => {
  const { sports, loading, error, createSport, deleteSport } = useSports();
  const { createSportType } = useSportTypes();
  const [showForm, setShowForm] = useState(false);
  const [showSportTypeForm, setShowSportTypeForm] = useState(false);

  const handleCreateSport = async (name: string, sportType: string) => {
    await createSport(name, sportType);
    setShowForm(false);
  };

  const handleDeleteSport = async (id: number) => {
    if (window.confirm('Êtes-vous sûr de vouloir supprimer ce sport et toutes ses compétitions ?')) {
      try {
        await deleteSport(id);
      } catch (err) {
        alert('Erreur lors de la suppression');
      }
    }
  };

  const handleCreateSportType = async (
    code: string,
    label: string,
    types: ('individuel' | 'collectif')[]
  ) => {
    await createSportType(code, label, types);
    setShowSportTypeForm(false);
  };

  return (
    <div className="min-vh-100 bg-light">
      <header className="bg-primary text-white py-5 mb-4">
        <div className="container">
          <h1 className="display-4 mb-2">Gestion des Sports</h1>
          <p className="lead mb-0">
            Créez et gérez vos sports, compétitions et championnats
          </p>
        </div>
      </header>

      <main className="container pb-5">
        <div className="text-center mb-4">
          {!showForm && !showSportTypeForm && (
            <div className="d-flex gap-3 justify-content-center flex-wrap">
              <button
                className="btn btn-primary btn-lg"
                onClick={() => setShowForm(true)}
              >
                + Créer un nouveau sport
              </button>
              <button
                className="btn btn-success btn-lg"
                onClick={() => setShowSportTypeForm(true)}
              >
                + Créer un type de sport
              </button>
            </div>
          )}
        </div>

        {showForm && (
          <div className="mb-4">
            <SportForm
              onSubmit={handleCreateSport}
              onCancel={() => setShowForm(false)}
            />
          </div>
        )}

        {showSportTypeForm && (
          <div className="mb-4">
            <div className="row justify-content-center">
              <div className="col-md-8 col-lg-6">
                <SportTypeForm
                  onSubmit={handleCreateSportType}
                  onCancel={() => setShowSportTypeForm(false)}
                />
              </div>
            </div>
          </div>
        )}

        <SportList
          sports={sports}
          loading={loading}
          error={error}
          onDeleteSport={handleDeleteSport}
        />
      </main>
    </div>
  );
};
